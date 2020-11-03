<?php

use GuzzleHttp\Client;
use TheRestartProject\RepairDirectory\Tests\IntegrationTestCase;

class GravityFormsTest extends IntegrationTestCase
{
    //use DatabaseMigrations;

    /**
     * @test
     */
    public function it_pulls_back_submissions()
    {
        $consumer_key = env('GRAVITYFORMS_KEY');
        $consumer_secret = env('GRAVITYFORMS_SECRET');

        $headers = ['Authorization' => 'Basic ' . base64_encode( "{$consumer_key}:{$consumer_secret}" ) ];

        $client = new GuzzleHttp\Client([
            'base_uri' => 'https://therestartproject.org/wp-json/gf/v2/'
        ]);
        $response = $client->request('GET', 'forms/29/entries', [
            'headers' => $headers,
        ]);

        dd(json_decode($response->getBody()->getContents()));
    }
}
