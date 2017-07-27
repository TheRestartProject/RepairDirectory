<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit;

use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Infrastructure\Repositories\DoctrineBusinessRepository;
use TheRestartProject\RepairDirectory\Tests\TestCase;


class DoctrineBusinessRepositoryTest extends TestCase
{
    /**
     * The repository to be tested
     *
     * @var DoctrineBusinessRepository
     */
    private $repository;

    public function setUp() {
        parent::setUp();
        $this->repository = $this->app->make(DoctrineBusinessRepository::class);
    }

    public function testAdd()
    {
        $business = new Business();
        $business->setName('iRepair Centre Bath');
        $business->setAddress('12 Westgate St, Bath');
        $business->setPostcode('BA1 1EQ');

        $retrievedBusinesses = $this->repository->getAll();
        $this->assertEquals(1, count($retrievedBusinesses));

        /** @var Business $retrievedBusiness */
        $retrievedBusiness = $retrievedBusinesses[0];
        $this->assertEquals('iRepair Centre Bath', $retrievedBusiness->getName());
        $this->assertEquals('12 Westgate St, Bath', $retrievedBusiness->getAddress());
        $this->assertEquals('BA1 1EQ', $retrievedBusiness->getPostcode());
    }
}
