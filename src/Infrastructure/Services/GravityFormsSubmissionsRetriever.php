<?php

namespace TheRestartProject\RepairDirectory\Infrastructure\Services;

use TheRestartProject\RepairDirectory\Domain\Models\Submission;

use GuzzleHttp\Client;

class GravityFormsSubmissionsRetriever
{
    private $consumerKey;
    private $consumerSecret;
    private $client;

    public function __construct()
    {
        $this->consumerKey = config('gravityforms.api_key');
        $this->consumerSecret = config('gravityforms.api_secret');
        $this->submissionsFormId = config('gravityforms.submissions_form_id');

        $this->client = new Client([
            'base_uri' => 'https://therestartproject.org/wp-json/gf/v2/',
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode( "{$this->consumerKey}:{$this->consumerSecret}" )
            ]
        ]);

    }

    public function retrieve()
    {
        $response = $this->client->request('GET', "forms/{$this->submissionsFormId}/entries");
        $json = json_decode($response->getBody()->getContents());

        $submissions = [];
        foreach ($json->entries as $submissionData) {
            $submissions[] = new Submission($submissionData);
        }

        return $submissions;
    }
}
