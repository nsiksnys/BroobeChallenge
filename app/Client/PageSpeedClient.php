<?php

namespace App\Client;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class PageSpeedClient
{
    private $apiKey;
    private $endpoint;
    private ResponseInterface $response;

    public function __construct() {
        $this->apiKey = env('GOOGLE_API_KEY');
        $this->endpoint = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed';
    }

    public function sendRequest($params)
    {
        $client = new Client([
            'base_uri' => $this->endpoint
        ]);

        $query = implode('&', array_merge($params, [ 'key=' . $this->apiKey ]));

        $this->response = $client->request('GET', '', [ 'query' => $query ]);
    }

    public function getEndpoint()
    {
        return $this->endpoint;
    }

    public function getResponseStatusCode()
    {
        return $this->response->getStatusCode();
    }

    public function getFromResponseContents($key)
    {
        return json_decode($this->response->getBody()->getContents(), true)[$key];
    }

    public function getLighthouseResult()
    {
        return $this->getFromResponseContents("lighthouseResult");
    }
}
