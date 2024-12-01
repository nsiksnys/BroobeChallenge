<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Validator;
use App\Client\PageSpeedClient;

class InsightsRequestController extends Controller
{
    // The guzzle http client
    private $client;

    // Logger
    private $log;

    public function __construct(Logger $logger)
    {
        $this->client = new PageSpeedClient();
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
        $params = $this->getParams($validated);

        try {
            $this->log->info('Sending GET request to ' . $this->client->getEndpoint());
            $this->client->sendRequest($params);
            $this->log->info("Insight request - Request executed. Response code: " . $this->client->getResponseStatusCode());

            return response()->json($this->client->getLighthouseResult());
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            $this->log->error("Insight request - " . $e->getMessage());
            return response()->json("Something went wrong. Please try again later")->setStatusCode(500);
        }
    }

    /**
     * Get the parameters we will send to the API
     */
    private function getParams($array)
    {
        $params = [];
        if (strlen($array['url']) > 0) {
            $params[] = "url=" . $array['url'];
        }

        if (count($array['categories']) > 0) {
            foreach ($array['categories'] as $item) {
                $params[] = "category=" . $item;
            }
        }

        if (strlen($array['strategy']) > 0) {
            $params[] = "strategy=" . $array['strategy'];
        }
        return $params;
    }
}
