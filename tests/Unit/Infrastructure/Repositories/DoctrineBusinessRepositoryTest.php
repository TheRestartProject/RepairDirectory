<?php
/**
 * Created by PhpStorm.
 * User: matt
 * Date: 26/07/17
 * Time: 22:47
 */

namespace TheRestartProject\RepairDirectory\Tests\Unit\Infrastructure\Repositories;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Mockery;
use Mockery\MockInterface;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Infrastructure\Repositories\DoctrineBusinessRepository;
use TheRestartProject\RepairDirectory\Tests\TestCase;

class DoctrineBusinessRepositoryTest extends TestCase
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
     * @var DoctrineBusinessRepository
     */
    private $doctrineBusinessRepository;

    public function setUp()
    {
        parent::setUp();
        $this->entityManager = Mockery::mock(EntityManager::class);
        $this->entityRepository = Mockery::mock(EntityRepository::class);

        $this->entityManager->shouldReceive('getRepository')->andReturn($this->entityRepository);

        /** @var EntityManager $entityManager */
        $entityManager = $this->entityManager;
        $this->doctrineBusinessRepository = new DoctrineBusinessRepository($entityManager);
    }

    /**
     * @test
     */
    public function it_can_be_instantiated()
    {
        /** @var EntityManager $entityManager */
        $entityManager = Mockery::spy(EntityManager::class);
        $repository = new DoctrineBusinessRepository($entityManager);
        self::assertInstanceOf(DoctrineBusinessRepository::class, $repository);
    }

    /**
     * @test
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
     * @test
     */
    public function it_can_retrieve_all_businesses()
    {
        $this->entityRepository->shouldReceive('findAll');
        $this->doctrineBusinessRepository->getAll();
        $this->entityRepository
            ->shouldHaveReceived('findAll')
            ->once();
    }
}
