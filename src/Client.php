<?php

namespace Ftuzlu\OpenAI;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;

class Client
{
    private GuzzleClient $client;
    private string $baseUrl;

    public function __construct(
        protected string $bearerToken,
        protected string $openAIOrganization,
        string $baseUrl = 'https://api.openai.com/'
    ) {
        $this->bearerToken = $bearerToken;
        $this->openAIOrganization = $openAIOrganization;
        $this->baseUrl = $baseUrl;

        $this->client = new GuzzleClient([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->bearerToken,
                'Content-Type' => 'application/json',
            ]
        ]);
    }

    private function client(): GuzzleClient
    {
        return $this->client;
    }

    public function post(string $url, array $options): mixed
    {
        return $this->request('POST', $url, $options);
    }

    public function get(string $url, array $options = []): mixed
    {
        return $this->request('GET', $url, $options);
    }

    public function chat(array $data): mixed
    {
        return $this->post('/v1/chat/completions', ['json' => $data]);
    }

    private function request(string $method, string $url, array $options): mixed
    {
        try {
            $response = $this->client()->request($method, $url, $options);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }
}
