<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use League\Tactician\CommandBus;
use TheRestartProject\RepairDirectory\Application\Commands\Suggestion\AddSuggestion\AddSuggestionCommand;
use TheRestartProject\RepairDirectory\Domain\Models\Suggestion;
use TheRestartProject\RepairDirectory\Domain\Repositories\SuggestionRepository;

class SuggestionController extends Controller
{
    public function search(Request $request, SuggestionRepository $repository)
    {
        $field = $request->input('field');
        $prefix = $request->input('prefix');

        if (!$field || !$prefix) {
            return response('You must include a field and a prefix', 400);
        }

        $suggestions = $repository->find($field, $prefix);

        $values = array_map(
            function (Suggestion $suggestion) {
                return $suggestion->getValue();
            },
            $suggestions
        );

        return $values;
    }
}
