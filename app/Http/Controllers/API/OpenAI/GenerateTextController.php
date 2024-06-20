<?php

namespace App\Http\Controllers\API\OpenAI;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Requests\GenerateTextRequest;
use GuzzleHttp\Client;

class GenerateTextController extends BaseController
{
    public function generateText(GenerateTextRequest $request)
    {
        $client = new Client();

        $requestBody = json_encode([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => $request->input],
            ],
        ]);

        try {
            $response = $client->request('POST', env("OPENAI_API_URL") . '/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                    'Content-Type' => 'application/json',
                ],
                'body' => $requestBody,
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return $this->sendError($e->getMessage(), [], $e->getCode());
        }

        // Procesar la respuesta de la API
        $responseData = json_decode($response->getBody()->getContents());
        $generatedText = $responseData->choices[0]->message->content;

        return $this->sendResponse($generatedText, "Assistant response", 200);
    }
}
