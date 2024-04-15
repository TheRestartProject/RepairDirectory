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
            'base_uri' => 'https://londonrepairs.org/wp-json/gf/v2/',
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode( "{$this->consumerKey}:{$this->consumerSecret}" )
            ]
        ]);

    }

    public function retrieve($entryId)
    {
        $response = $this->client->request('GET', "entries/{$entryId}");
        $json = json_decode($response->getBody()->getContents());

        $submission = new Submission($json);

        return $submission;
    }

    public function retrieveAll()
    {
        // We retrieve 100 entries, sorted by creation date, to ensure we see all recent submissions.
        // 100 works fine for now, while submission rate is low.  If it increases significantly, we'll likely
        // switch to an in-app form.
        $response = $this->client->request('GET', "forms/{$this->submissionsFormId}/entries?paging[page_size]=100&sorting[key]=date_created&sorting[direction]=DESC");
        $json = json_decode($response->getBody()->getContents());

        $submissions = [];
        foreach ($json->entries as $submissionData) {
            $submissions[] = new Submission($submissionData);
        }

        return $submissions;
    }
}
