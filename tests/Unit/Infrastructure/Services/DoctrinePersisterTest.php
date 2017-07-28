<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Infrastructure\Services;

use Doctrine\ORM\EntityManager;
use Mockery;
use Mockery\MockInterface;
use TheRestartProject\RepairDirectory\Infrastructure\Services\DoctrinePersister;
use TheRestartProject\RepairDirectory\Tests\TestCase;

/**
 * Class DoctrinePersisterTest
 *
 * @category Class
 * @package  TheRestartProject\RepairDirectory\Tests\Unit\Infrastructure\Services
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class DoctrinePersisterTest extends TestCase
{
    /**
     * Mock EntityManager
     *
     * @var MockInterface
     */
    private $entityManager;

    /**
     * The service to test
     *
     * @var DoctrinePersister
     */
    private $doctrinePersister;

    /**
     * Set up the mocks and services used in the test.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->entityManager = Mockery::mock(EntityManager::class);

        /**
         * Cast mock to EntityManager
         *
         * @var EntityManager $entityManager
         */
        $entityManager = $this->entityManager;
        $this->doctrinePersister = new DoctrinePersister($entityManager);
    }

    /**
     * Test that the service can be instantiated
     *
     * @test
     *
     * @return void
     */
    public function it_can_be_instantiated()
    {
        /**
         * Cast mock to EntityManager
         *
         * @var EntityManager $entityManager
         */
        $entityManager = Mockery::spy(EntityManager::class);
        $persister = new DoctrinePersister($entityManager);
        self::assertInstanceOf(DoctrinePersister::class, $persister);
    }

    /**
     * Test that the service propagates persistence to doctrine.
     *
     * @test
     *
     * @return void
     */
    public function it_can_persist_changes()
    {
        $this->entityManager->shouldReceive('flush');
        $this->doctrinePersister->persistChanges();
        $this->entityManager->shouldHaveReceived('flush')->once();
    }
}
