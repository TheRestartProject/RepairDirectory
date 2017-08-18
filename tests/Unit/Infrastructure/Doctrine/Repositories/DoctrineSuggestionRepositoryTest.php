<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Infrastructure\Doctrine\Repositories;

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
     * Set up the mocks for the test
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->entityManager = Mockery::mock(EntityManager::class);
        $this->entityRepository = Mockery::mock(EntityRepository::class);

        /**
         * Cast mock to EntityManager.
         *
         * @var EntityManager $entityManager
         */
        $entityManager = $this->entityManager;
        $this->entityManager->shouldReceive('getRepository')
            ->andReturn($this->entityRepository);

        $this->doctrineSuggestionRepository
            = new DoctrineSuggestionRepository($entityManager);
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
         * Cast to EntityManager to squash type hint errors.
         *
         * @var EntityManager $entityManager
         */
        $entityManager = Mockery::spy(EntityManager::class);
        $repository = new DoctrineSuggestionRepository($entityManager);
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
