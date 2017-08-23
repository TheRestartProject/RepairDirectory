<?php

namespace TheRestartProject\RepairDirectory\Tests\Integration\Infrastructure\Doctrine\Repositories;

use Doctrine\Common\Persistence\ManagerRegistry;
use TheRestartProject\Fixometer\Domain\Entities\User;
use TheRestartProject\Fixometer\Domain\Repositories\UserRepository;
use TheRestartProject\Fixometer\Infrastructure\Doctrine\Repositories\DoctrineUserRepository;
use TheRestartProject\RepairDirectory\Testing\DatabaseMigrations;
use TheRestartProject\RepairDirectory\Tests\IntegrationTestCase;

/**
 * Class DoctrineUserRepositoryTest
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Integration\Infrastructure\Doctrine\Repositories
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     https://laravel.com/docs/5.4/
 */
class DoctrineUserRepositoryTest extends IntegrationTestCase
{
    use DatabaseMigrations;

    /**
     * The repository under test
     *
     * @var \TheRestartProject\Fixometer\Infrastructure\Doctrine\Repositories\DoctrineUserRepository
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
         * @var \TheRestartProject\Fixometer\Domain\Entities\User $user
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

    /**
     * Tests that it returns false if there is no user
     *
     * @test
     *
     * @return void
     */
    public function it_returns_false_if_no_user_exists_with_that_id()
    {
        $result = $this->repository->hasUserById(1);

        self::assertFalse($result);
    }

    /**
     * Test that it returns true if a user exists
     *
     * @test
     *
     * @return void
     */
    public function it_returns_user_if_a_user_exists_with_that_id()
    {
        /**
         * The created user
         *
         * @var User $user
         */
        $user = entity(User::class)->create();

        $result = $this->repository->hasUserById($user->getUid());

        self::assertTrue($result);
    }
}
