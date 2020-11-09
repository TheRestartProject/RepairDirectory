<?php

use TheRestartProject\RepairDirectory\Tests\IntegrationTestCase;
use TheRestartProject\RepairDirectory\Infrastructure\Services\GravityFormsSubmissionsRetriever;

class GravityFormsSubmissionsTest extends IntegrationTestCase
{
    //use DatabaseMigrations;

    /**
     * @test
     */
    public function it_pulls_back_all_submissions()
    {
        $submissionsRetriever = new GravityFormsSubmissionsRetriever();

        $submissions = $submissionsRetriever->retrieveAll();

        dd($submissions);
    }

    /**
     * @test
     */
    public function it_pulls_back_single_submission()
    {
        $submissionsRetriever = new GravityFormsSubmissionsRetriever();

        $submission = $submissionsRetriever->retrieve(5949);

        dd($submission);
    }
}
