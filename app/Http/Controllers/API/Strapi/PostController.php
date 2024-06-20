<?php

namespace App\Http\Controllers\API\Strapi;

use App\Http\Controllers\API\BaseController as BaseController;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class PostController extends BaseController
{
    public function index()
    {
        $client = new Client();
        $base_url = env("STRAPI_URL") . "/api/posts?fields[0]=title&populate[author][fields][0]=name&populate[comments][fields][0]=comment&populate[comments][populate][author][fields][0]=name";

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
            $comments = [];
            for ($j = 0; $j < count($responseData->data[$i]->attributes->comments->data); $j++) {
                $comments[] = [
                    "id " => $responseData->data[$i]->attributes->comments->data[$j]->id,
                    "comment" => $responseData->data[$i]->attributes->comments->data[$j]->attributes->comment,
                    "author" => $responseData->data[$i]->attributes->comments->data[$j]->attributes->author->data->attributes->name,
                ];
            };

            $data[] = [
                "id" => $responseData->data[$i]->id,
                "title" => $responseData->data[$i]->attributes->title,
                "author" => $responseData->data[$i]->attributes->author->data->attributes->name,
                "comments" => $comments,
            ];
        }

        return $this->sendResponse($data, "Post list", $response->getStatusCode());
    }

    public function show($id)
    {
        $client = new Client();
        $base_url = env("STRAPI_URL") . "/api/posts/" . $id . "?fields[0]=title&populate[author][fields][0]=name&populate[comments][fields][0]=comment&populate[comments][populate][author][fields][0]=name";

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

        $comments = [];
        for ($i = 0; $i < count($responseData->data->attributes->comments->data); $i++) {
            $comments[] = [
                "id " => $responseData->data->attributes->comments->data[$i]->id,
                "comment" => $responseData->data->attributes->comments->data[$i]->attributes->comment,
                "author" => $responseData->data->attributes->comments->data[$i]->attributes->author->data->attributes->name,
            ];
        };

        // Formatear la respuesta
        $data = [
            "id" => $responseData->data->id,
            "title" => $responseData->data->attributes->title,
            "author" => $responseData->data->attributes->author->data->attributes->name,
            "comments" => $comments,
        ];

        return $this->sendResponse($data, "Post detail", $response->getStatusCode());
    }
}
