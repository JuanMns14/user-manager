<?php

namespace App\Http\Controllers\API\Strapi;

use App\Http\Controllers\API\BaseController as BaseController;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class CommentController extends BaseController
{
    public function index()
    {
        $client = new Client();
        $base_url = env("STRAPI_URL") . "/api/comments?fields[0]=comment&populate[post][fields][0]=title&populate[post][fields][1]=author&populate[author][fields][0]=name";

        try {
            $response = $client->request('GET', $base_url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('STRAPI_API_KEY'),
                    'Content-Type' => 'application/json',
                ],

            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return $this->sendError($e->getMessage(), [], $e->getCode());
        }

        // Procesar la respuesta de la API
        $responseData = json_decode($response->getBody()->getContents());

        // Formatear la respuesta
        $data = [];
        for ($i = 0; $i < count($responseData->data); $i++) {
            $data[] = [
                "id" => $responseData->data[$i]->id,
                "comment" => $responseData->data[$i]->attributes->comment,
                "author" => $responseData->data[$i]->attributes->author->data->attributes->name,
                "post" => $responseData->data[$i]->attributes->post->data->attributes->title,
            ];
        }

        return $this->sendResponse($data, "Comment list", $response->getStatusCode());
    }

    public function show($id)
    {
        $client = new Client();
        $base_url = env("STRAPI_URL") . "/api/comments/" . $id . "?fields[0]=comment&populate[post][fields][0]=title&populate[post][fields][1]=author&populate[author][fields][0]=name";

        try {
            $response = $client->request('GET', $base_url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('STRAPI_API_KEY'),
                    'Content-Type' => 'application/json',
                ],

            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return $this->sendError($e->getMessage(), [], $e->getCode());
        }

        // Procesar la respuesta de la API
        $responseData = json_decode($response->getBody()->getContents());

        // Formatear la respuesta
        $data = [
            "id" => $responseData->data->id,
            "comment" => $responseData->data->attributes->comment,
            "author" => $responseData->data->attributes->author->data->attributes->name,
            "post" => $responseData->data->attributes->post->data->attributes->title,
        ];

        return $this->sendResponse($data, "Comment detail", $response->getStatusCode());
    }
}
