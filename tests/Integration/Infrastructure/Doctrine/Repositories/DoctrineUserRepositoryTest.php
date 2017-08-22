<?php

namespace TheRestartProject\RepairDirectory\Tests\Integration\Infrastructure\Doctrine\Repositories;

use Doctrine\Common\Persistence\ManagerRegistry;
use TheRestartProject\RepairDirectory\Domain\Models\User;
use TheRestartProject\RepairDirectory\Domain\Repositories\UserRepository;
use TheRestartProject\RepairDirectory\Infrastructure\Doctrine\Repositories\DoctrineUserRepository;
use TheRestartProject\RepairDirectory\Testing\DatabaseMigrations;
use TheRestartProject\RepairDirectory\Tests\IntegrationTestCase;

/**
 * Class DoctrineUserRepositoryTest
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Integration\Infrastructure\Doctrine\Repositories
 * @author   Matthew Kendon <matt@outlandish.com>
 */
class DoctrineUserRepositoryTest extends IntegrationTestCase
{
    use DatabaseMigrations;

    /**
     * The repository under test
     *
     * @var DoctrineUserRepository
     */
    protected $repository;

    /**
     * Set up the test environment before each test
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->repository = new DoctrineUserRepository(
            $this->app->make(ManagerRegistry::class)
                ->getManagerForClass(User::class)
        );
    }

    /**
     * Tests that the repository returns empty if no users
     *
     * @test
     *
     * @return void
     */
    public function it_returns_an_empty_collection_if_there_are_no_users()
    {
        $users = $this->repository->findAll();

        self::assertEmpty($users);
    }

    /**
     * Tests that the repository can find all users
     *
     * @test
     *
     * @return void
     */
    public function it_returns_all_users_if_there_are_any_users()
    {
        $count = 6;

        entity(User::class, $count)->create();

        $users = $this->repository->findAll();

        self::assertCount($count, $users);
    }

    /**
     * Tests that the repository returns null if it cannot find a user
     *
     * @test
     *
     * @return void
     */
    public function it_returns_null_if_it_cannot_find_a_user_by_id()
    {
        $user = $this->repository->find(1);

        self::assertNull($user);
    }

    /**
     * Tests that it returns the user for a given id
     *
     * @test
     *
     * @return void
     */
    public function it_returns_the_user_for_a_given_id_if_it_exists()
    {
        /**
         * The created user
         *
         * @var User $user
         */
        $user = entity(User::class)->create();

        /**
         * The found user from the repository
         *
         * @var User $foundUser
         */
        $foundUser = $this->repository->find($user->getUid());

        self::assertInstanceOf(User::class, $foundUser);
        self::assertEquals($user->getUid(), $foundUser->getUid());
    }
}
