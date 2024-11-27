<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Validator;
use Psr\Http\Message\ResponseInterface;

class InsightsRequestController extends Controller
{
    // The guzzle http client
    private $client;

    // Credentials needed to query the Google Insights API
    private $credentials;

    // Logger
    private $log;

    public function __construct(Logger $logger)
    {
        $this->credentials = [
            'url' => env('GOOGLE_API_URL'),
            'key' => env('GOOGLE_API_KEY')
        ];
        $this->client = new Client();
        $this->log = $logger;
    }

    public function get(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|url:http,https|max:255',
            'strategy' => 'required|string',
            'categories' => 'required|array'
        ]); 

        if ($validator->fails()) {
            $errors = [];
            foreach($validator->errors()->getMessages() as $input => $messages ) {
                $errors[] = strtoupper($input) . ': ' . implode(',', $messages);
            }
            $errorMessage = "The following errors were found - " . implode(' ',$errors);
            $this->log->error("Insight request - validation failed.");
            return response()->json($errorMessage)->setStatusCode(400);
        }
 
        // Get the validated inputs.
        // This is better than calling one by one like before
        $validated = $validator->validated();
        $params = $this->getParams($validated['url'], $validated['categories'], $validated['strategy']);

        try {
            $response = $this->sendRequest($params);
            $this->log->info("Insight request - Request executed. Response code: " . $response->getStatusCode());

            return response()->json($this->handleResponse($response->getBody()->getContents()));
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            $this->log->error("Insight request - " . $e->getMessage());
            return response()->json("Something went wrong. Please try again later")->setStatusCode(500);
        }
    }

    private function sendRequest($params): ResponseInterface
    {
        $this->log->info('Sending GET request to ' . $this->credentials['url']);
        $response = $this->client->request('GET', $this->credentials['url'], ['query' => implode('&', $params)]);
        return $response;
    }

    private function getParams($url, $categories, $strategy)
    {
        $params = [];
        if (strlen($url) > 0) {
            $params[] = "url=" . $url;
        }

        $params[] = 'key=' . $this->credentials['key'];

        if (count($categories) > 0) {
            foreach ($categories as $item) {
                $params[] = "category=" . $item;
            }
        }

        if (strlen($strategy) > 0) {
            $params[] = "strategy=" . $strategy;
        }
        return $params;
    }

    private function handleResponse($response)
    {
        $arrayResponse = json_decode($response, true);
        $categories = $arrayResponse['lighthouseResult'];

        return $categories;
    }
}
