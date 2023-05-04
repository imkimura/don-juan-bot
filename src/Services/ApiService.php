<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;

class ApiService
{
    /** @var Client */
    private Client $client;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => getenv('BASE_API')
        ]);
    }

    /**
     * Return flirts
     *
     * @return array
     */
    public function flirts()
    {
        try {
            $response = $this->client->request('GET', '/flirts');

            return json_decode($response->getBody(), true) ?? [];
        } catch (Exception $e) {
            return [];
        }
    }
}