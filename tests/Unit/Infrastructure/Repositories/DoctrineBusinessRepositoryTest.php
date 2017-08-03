<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Infrastructure\Repositories;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Mockery;
use Mockery\MockInterface;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Infrastructure\Doctrine\Repositories\
DoctrineBusinessRepository;
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

        $this->doctrineBusinessRepository
            = new DoctrineBusinessRepository($entityManager);
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
        $repository = new DoctrineBusinessRepository($entityManager);
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
        $this->doctrineBusinessRepository->getAll();
        $this->entityRepository
            ->shouldHaveReceived('findAll')
            ->once();
    }
}
