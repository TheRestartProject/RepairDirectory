<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Application\Commands;

use TheRestartProject\RepairDirectory\Application\Commands\Suggestion\AddSuggestion\AddSuggestionCommand;
use TheRestartProject\RepairDirectory\Application\Commands\Suggestion\AddSuggestion\AddSuggestionHandler;
use TheRestartProject\RepairDirectory\Domain\Models\Suggestion;
use TheRestartProject\RepairDirectory\Domain\Repositories\SuggestionRepository;
use TheRestartProject\RepairDirectory\Tests\TestCase;
use \Mockery as m;

/**
 * Test for the AddSuggestion command
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Unit\Application\Business\Handlers
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class AddSuggestionTest extends TestCase
{
    /**
     * The Handler under test
     *
     * @var AddSuggestionHandler
     */
    private $handler;

    /**
     * The mocked repository
     *
     * @var m\MockInterface
     */
    private $repository;

    /**
     * Setups the the handler under test for each test
     *
     * @return void
     */
    public function setUp()
    {
        $this->repository = m::spy(SuggestionRepository::class);

        /**
         * Cast mock to SuggestionRepository
         *
         * @var SuggestionRepository $repository
         */
        $repository = $this->repository;

        $this->handler = new AddSuggestionHandler(
            $repository
        );
    }

    /**
     * Tests that it can be constructed
     *
     * This test confirms that the handler can be constructed with
     * the correct dependencies.
     *
     * @test
     *
     * @return void
     */
    public function it_can_be_constructed()
    {
        /**
         * Cast mock to SuggestionRepository
         *
         * @var SuggestionRepository $repository
         */
        $repository = m::spy(SuggestionRepository::class);

        $handler = new AddSuggestionHandler($repository);
        self::assertInstanceOf(AddSuggestionHandler::class, $handler);
    }

    /**
     * Tests that the handler works
     *
     * Tests that the handler successfully creates a Suggestion and persists it
     *
     * @test
     *
     * @return void
     */
    public function it_can_add_a_suggestion_to_the_repository()
    {
        $addedSuggestion = $this->handler->handle(new AddSuggestionCommand('foo', 'bar'));

        $this->assertSuggestionAdded($addedSuggestion);
        self::assertInstanceOf(Suggestion::class, $addedSuggestion);
    }

    /**
     * Asserts that the suggestion was added to the repository
     *
     * @param Suggestion $suggestion the model that was added to the repository
     *
     * @return void
     */
    public function assertSuggestionAdded($suggestion)
    {
        $this->repository->shouldHaveReceived('add')
            ->with($suggestion);
    }
}
