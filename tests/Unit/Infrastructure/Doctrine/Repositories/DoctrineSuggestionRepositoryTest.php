<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Infrastructure\Doctrine\Repositories;

use LaravelDoctrine\ORM\IlluminateRegistry;
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
     * @var IlluminateRegistry|MockInterface
     */
    protected $IlluminateRegistry;

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

        $this->IlluminateRegistry = Mockery::mock(IlluminateRegistry::class);
        $this->IlluminateRegistry->shouldReceive('getManagerForClass')->andReturn($this->entityManager);

        /**
         * Cast mock to IlluminateRegistry.
         *
         * @var IlluminateRegistry $IlluminateRegistry
         */
        $IlluminateRegistry = $this->IlluminateRegistry;

        $this->doctrineSuggestionRepository
            = new DoctrineSuggestionRepository($IlluminateRegistry);
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
         * Cast to IlluminateRegistry to squash type hint errors.
         *
         * @var IlluminateRegistry $IlluminateRegistry
         */
        $IlluminateRegistry = $this->IlluminateRegistry;
        $repository = new DoctrineSuggestionRepository($IlluminateRegistry);

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
