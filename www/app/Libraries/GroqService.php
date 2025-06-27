<?php

namespace App\Libraries;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class GroqService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.groq.com/openai/v1/',
            'timeout' => 10.0,
        ]);
        $this->apiKey = env('GROQ_API_KEY');
    }

    public function getModels()
    {
        try {
            $response = $this->client->get('models', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ]
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            log_message('error', 'Groq API Error: ' . $e->getMessage());
            return [
                'error' => true,
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ];
        }
    }

    public function message($model, $message)
    {
        try {
            $response = $this->client->post('chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ],
                'json' => [
                    'model' => $model,
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $message
                        ]
                    ]
                ]
            ]);

            $responseData = json_decode($response->getBody(), true);

            if (isset($responseData['choices'][0]['message']['content'])) {
                return [
                    'success' => true,
                    'response' => $responseData['choices'][0]['message']['content'],
                ];
            }

            return [
                'success' => false,
                'message' => 'Respuesta inesperada de la API',
                'response' => $responseData
            ];
        } catch (RequestException $e) {
            $errorResponse = $e->hasResponse() ? json_decode($e->getResponse()->getBody(), true) : null;

            return [
                'success' => false,
                'status_code' => $e->getCode(),
                'message' => $errorResponse['error']['message'] ?? $e->getMessage(),
                'type' => $errorResponse['error']['type'] ?? null
            ];
        }
    }

    public function messageWithContext($model, $messages)
    {
        try {
            $response = $this->client->post('chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => $model,
                    'messages' => $messages,
                    'temperature' => 0.7,
                    'max_tokens' => 1024
                ]
            ]);

            $responseData = json_decode($response->getBody(), true);

            return [
                'success' => true,
                'response' => $responseData['choices'][0]['message']['content'],
                'full_response' => $responseData
            ];

        } catch (RequestException $e) {
            $errorResponse = $e->hasResponse() ? json_decode($e->getResponse()->getBody(), true) : null;

            return [
                'success' => false,
                'status_code' => $e->getCode(),
                'message' => $errorResponse['error']['message'] ?? $e->getMessage(),
                'type' => $errorResponse['error']['type'] ?? null
            ];
        }
    }
}