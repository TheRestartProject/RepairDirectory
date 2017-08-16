<?php

use Illuminate\Database\Seeder;
use TheRestartProject\RepairDirectory\Domain\Models\Suggestion;

class SuggestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        entity(Suggestion::class)->create([
            'field' => 'test',
            'value' => 'food'
        ]);

        entity(Suggestion::class)->create([
            'field' => 'test',
            'value' => 'football'
        ]);

        entity(Suggestion::class)->create([
            'field' => 'test',
            'value' => 'golf'
        ]);

        entity(Suggestion::class)->create([
            'field' => 'other',
            'value' => 'football'
        ]);
    }
}
