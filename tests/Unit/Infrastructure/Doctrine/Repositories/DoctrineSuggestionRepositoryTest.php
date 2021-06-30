<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Infrastructure\Doctrine\Repositories;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Mockery;
use Mockery\MockInterface;
use TheRestartProject\RepairDirectory\Domain\Models\Suggestion;
use TheRestartProject\RepairDirectory\Infrastructure\Doctrine\Repositories\DoctrineSuggestionRepository;
use TheRestartProject\RepairDirectory\Tests\TestCase;

/**
 * Class DoctrineSuggestionRepositoryTest
 *
 * @category Class
 * @package  TheRestartProject\RepairDirectory\Tests\Unit\Infrastructure\Repositories
 * @author   Matt Kendon <matt@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class DoctrineSuggestionRepositoryTest extends TestCase
{
    /**
     * Mock EntityManager
     *
     * @var MockInterface
     */
    private $entityManager;

    /**
     * A mocked version of the entity repository used for querying.
     *
     * @var MockInterface
     */
    private $entityRepository;

    /**
     * The repository to test
     *
     * @var DoctrineSuggestionRepository
     */
    private $doctrineSuggestionRepository;

    /**
     * The repository to test
     *
     * @var ManagerRegistry|MockInterface
     */
    protected $managerRegistry;

    /**
     * Set up the mocks for the test
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->entityManager = Mockery::mock(EntityManager::class);
        $this->entityRepository = Mockery::mock(EntityRepository::class);

        $this->entityManager->shouldReceive('getRepository')
            ->andReturn($this->entityRepository);

        $this->managerRegistry = Mockery::mock(ManagerRegistry::class);
        $this->managerRegistry->shouldReceive('getManagerForClass')->andReturn($this->entityManager);

        /**
         * Cast mock to ManagerRegistry.
         *
         * @var ManagerRegistry $managerRegistry
         */
        $managerRegistry = $this->managerRegistry;

        $this->doctrineSuggestionRepository
            = new DoctrineSuggestionRepository($managerRegistry);
    }

    /**
     * Test that the repository can be instantiated
     *
     * @test
     *
     * @return void
     */
    public function it_can_be_instantiated()
    {
        /**
         * Cast to ManagerRegistry to squash type hint errors.
         *
         * @var ManagerRegistry $managerRegistry
         */
        $managerRegistry = $this->managerRegistry;
        $repository = new DoctrineSuggestionRepository($managerRegistry);

        self::assertInstanceOf(DoctrineSuggestionRepository::class, $repository);
    }

    /**
     * Test that the repository can have a suggestion added to it
     *
     * @test
     *
     * @return void
     */
    public function it_can_add_a_suggestion()
    {
        $suggestion = new Suggestion();
        $this->entityManager->shouldReceive('persist');
        $this->doctrineSuggestionRepository->add($suggestion);
        $this->entityManager
            ->shouldHaveReceived('persist')
            ->once()
            ->with($suggestion);
    }
}
