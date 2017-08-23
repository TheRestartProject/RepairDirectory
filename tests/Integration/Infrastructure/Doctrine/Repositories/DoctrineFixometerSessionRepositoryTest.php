<?php

namespace TheRestartProject\RepairDirectory\Tests\Integration\Infrastructure\Doctrine\Repositories;

use Doctrine\Common\Persistence\ManagerRegistry;
use Illuminate\Support\Str;
use TheRestartProject\Fixometer\Domain\Entities\FixometerSession;
use TheRestartProject\Fixometer\Infrastructure\Doctrine\Repositories\DoctrineFixometerSessionRepository;
use TheRestartProject\RepairDirectory\Testing\FixometerDatabaseMigrations;
use TheRestartProject\RepairDirectory\Tests\IntegrationTestCase;

/**
 * Test class for the DoctrineFixometerSessionRepository
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Integration\Infrastructure\Doctrine\Repositories
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class DoctrineFixometerSessionRepositoryTest extends IntegrationTestCase
{
    use FixometerDatabaseMigrations;

    /**
     * The repository under test
     *
     * @var DoctrineFixometerSessionRepository
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
        $this->repository = new DoctrineFixometerSessionRepository(
            $this->app->make(ManagerRegistry::class)
        );
    }


    /**
     * Tests that the repository returns null if there are no sessions
     *
     * @test
     *
     * @return void
     */
    public function it_returns_null_if_there_is_no_session()
    {
        $session = $this->repository->findOneBySession(Str::random());

        self::assertNull($session);
    }

    /**
     * Tests the repository returns the correct session if one exists
     *
     * @test
     *
     * @return void
     */
    public function it_returns_the_correct_session_if_one_exists()
    {
        /**
         * The created fixometer session in the database
         *
         * @var FixometerSession $session
         */
        $session = entity(FixometerSession::class)->create();

        /**
         * The session found in the database
         *
         * @var FixometerSession $foundSession
         */
        $foundSession = $this->repository->findOneBySession($session->getSession());

        self::assertInstanceOf(FixometerSession::class, $foundSession);
        self::assertEquals($session->getSession(), $foundSession->getSession());
    }
}
