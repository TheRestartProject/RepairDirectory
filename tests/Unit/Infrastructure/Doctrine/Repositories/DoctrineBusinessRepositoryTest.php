<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Infrastructure\Doctrine\Repositories;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Mockery;
use Mockery\MockInterface;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Infrastructure\Doctrine\Repositories\DoctrineBusinessRepository;
use TheRestartProject\RepairDirectory\Tests\TestCase;

/**
 * Class DoctrineBusinessRepositoryTest
 *
 * @category Class
 * @package  TheRestartProject\RepairDirectory\Tests\Unit\Infrastructure\Repositories
 * @author   Matt Kendon <matt@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class DoctrineBusinessRepositoryTest extends TestCase
{
    /**
     * Mock EntityManager
     *
     * @var MockInterface|EntityManager
     */
    private $entityManager;

    /**
     * A mocked version of the entity repository used for querying.
     *
     * @var MockInterface|EntityRepository
     */
    private $entityRepository;

    /**
     * The repository to test
     *
     * @var DoctrineBusinessRepository
     */
    private $doctrineBusinessRepository;

    /**
     * The manager registry for doctrine orm
     *
     * @var MockInterface|ManagerRegistry
     */
    private $managerRegistry;

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
        $this->doctrineBusinessRepository = new DoctrineBusinessRepository($managerRegistry);
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
        $repository = new DoctrineBusinessRepository($managerRegistry);

        self::assertInstanceOf(DoctrineBusinessRepository::class, $repository);
    }

    /**
     * Test that the repository can have a business added to it
     *
     * @test
     *
     * @return void
     */
    public function it_can_add_a_business()
    {
        $business = new Business();
        $this->entityManager->shouldReceive('persist');
        $this->doctrineBusinessRepository->add($business);
        $this->entityManager
            ->shouldHaveReceived('persist')
            ->once()
            ->with($business);
    }

    /**
     * Test that all businesses can be retrieved from the business.
     *
     * @test
     *
     * @return void
     */
    public function it_can_retrieve_all_businesses()
    {
        $this->entityRepository->shouldReceive('findAll');
        $this->doctrineBusinessRepository->findAll();
        $this->entityRepository
            ->shouldHaveReceived('findAll')
            ->once();
    }
}
