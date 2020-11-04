<?php

use TheRestartProject\RepairDirectory\Tests\IntegrationTestCase;
use TheRestartProject\RepairDirectory\Infrastructure\Services\GravityFormsSubmissionsRetriever;

class GravityFormsSubmissionsTest extends IntegrationTestCase
{
    //use DatabaseMigrations;

    /**
     * @test
     */
    public function it_pulls_back_submissions()
    {
        $submissionsRetriever = new GravityFormsSubmissionsRetriever();

        $submissions = $submissionsRetriever->retrieve();

        dd($submissions);
    }
}
