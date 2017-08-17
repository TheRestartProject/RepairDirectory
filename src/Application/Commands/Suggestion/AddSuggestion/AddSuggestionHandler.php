<?php

namespace TheRestartProject\RepairDirectory\Application\Commands\Suggestion\AddSuggestion;

use TheRestartProject\RepairDirectory\Domain\Models\Suggestion;
use TheRestartProject\RepairDirectory\Domain\Repositories\SuggestionRepository;

/**
 * Handles the AddSuggestionCommand to add a Suggestion
 *
 * @category CommandHandler
 * @package  TheRestartProject\RepairDirectory\Application\Commands\Suggestion\AddSuggestion;
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class AddSuggestionHandler
{
    /**
     * An implementation of the SuggestionRepository
     *
     * @var SuggestionRepository
     */
    private $repository;

    /**
     * Creates the handler for the AddSuggestionCommand
     *
     * @param SuggestionRepository $repository An implementation of the BusinessRepository
     */
    public function __construct(SuggestionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handles the Command by adding a Suggestion to the database
     *
     * @param AddSuggestionCommand $command The command to handle
     *
     * @return Suggestion
     */
    public function handle(AddSuggestionCommand $command)
    {
        $suggestion = new Suggestion();
        $suggestion->setField($command->getField());
        $suggestion->setValue($command->getValue());
        $this->repository->add($suggestion);
        return $suggestion;
    }
}
