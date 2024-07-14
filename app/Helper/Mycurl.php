<?php

namespace App\Helper;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Redirect;


class Mycurl
{
    const TIME_OUT = 120;
//    const API_TOKEN = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGktbGRwLmhvY21haS52biIsImlhdCI6MTY0NTA5MDU5NSwiZXhwIjoxOTI4OTE0NTk1LCJuYmYiOjE2NDUwOTA1OTUsImp0aSI6IkMyRkJsNW5uWVBCTGtsQWsiLCJzdWIiOjEsInBydiI6IjJhYTYzOWRhMDk0YTY2OGE0ODRkZGUyZGY3NjRiOTg4Njk5MTI0OTYiLCJ0b2tlbiI6InNPMkVIaTMzaVZLcVpCR28ifQ._ScV05jMh2iQ4sdxa-RqQCwjrmq89cE6J21OM7ImwVE';
//    const API_TOKEN = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3QiLCJpYXQiOjE2NjY1OTQ1MjEsImV4cCI6MTk1MDQxODUyMSwibmJmIjoxNjY2NTk0NTIxLCJqdGkiOiJXTHJ0YWh2allGWVE0RmtLIiwic3ViIjoxLCJwcnYiOiIyYWE2MzlkYTA5NGE2NjhhNDg0ZGRlMmRmNzY0Yjk4ODY5OTEyNDk2IiwidG9rZW4iOiJjY1NQZlY0RkxsT3BBRnFxIn0.3K5Wy5vJoYKaCKLs7j3qPUC_83yyCL1zG0U79UGLi3A';

    public static function postCurl($url, $params = [])
    {
        $access_token = session()->get('access_token');
        try {

            $optionClient = array(
                'timeout' => self::TIME_OUT,
                'verify' => false
            );

            $client = new Client($optionClient);
            $headers = [
                'Authorization' => 'Bearer ' . $access_token,
                'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',
            ];
            $response = $client->post($url, [
                'headers' => $headers,
                'form_params' => $params
            ]);
            $content = $response->getBody()->getContents();

            $result = json_decode($content, true);

            $data = $result['data'];

            return $data;
        } catch (\Exception $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }
    }

    public static function putCurl($url, $params = [])
    {
        $access_token = session()->get('access_token');
        try {

            $optionClient = array(
                'timeout' => self::TIME_OUT,
                'verify' => false
            );

            $client = new Client($optionClient);
            $headers = [
                'Authorization' => 'Bearer ' . $access_token,
                'Content-Type' => 'application/x-www-form-urlencoded',
            ];

            $response = $client->put($url, [
                'headers' => $headers,
                'form_params' => $params
            ]);
            $content = $response->getBody()->getContents();

            $result = json_decode($content, true);
            $data = $result['data'];

            return $data;
        } catch (\Exception $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }
    }

    public static function deleteCurl($url, $params = [])
    {
        $access_token = session()->get('access_token');
        try {

            $optionClient = array(
                'timeout' => self::TIME_OUT,
                'verify' => false
            );

            $client = new Client($optionClient);
            $headers = [
                'Authorization' => 'Bearer ' . $access_token,
                'Content-Type' => 'application/x-www-form-urlencoded',
            ];

            $response = $client->delete($url, [
                'headers' => $headers,
                'form_params' => $params
            ]);
            $content = $response->getBody()->getContents();

            $result = json_decode($content, true);
            $data = $result['data'];

            return $data;
        } catch (\Exception $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }
    }

    public static function getCurl($url, $params = [])
    {
        $access_token = session()->get('access_token');
        try {
            $optionClient = array(
                'verify' => false
            );

            $client = new Client($optionClient);
            $headers = [
                'Authorization' => 'Bearer ' . $access_token,
            ];
            $response = $client->get($url,
                [
                    'headers' => $headers,
                    'query' => $params
                ]
            );
            $content = $response->getBody()->getContents();

            $result = json_decode($content, true);
            $data = $result['data'];

            return $data;
        } catch (\Exception $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }
    }

    public static function get($url, $params = [])
    {

        try {

            $optionClient = array(
                'timeout' => self::TIME_OUT,
                'verify' => false
            );

            $client = new Client($optionClient);

            $response = $client->get($url,
                [
                    'query' => $params
                ]
            );
            $content = $response->getBody()->getContents();

            $result = json_decode($content, true);
            $data = $result['data'];

            return $data;

        } catch (\Exception $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }
    }

    public function post($url, $params = [])
    {


        try {
            $optionClient = array(
                'timeout' => self::TIME_OUT,
                'verify' => false
            );

            $client = new Client($optionClient);
            $headers = [
                'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',
            ];


            $response = $client->post($url, [
                'headers' => $headers,
                'form_params' => $params
            ]);
            $content = $response->getBody()->getContents();

            $result = json_decode($content, true);

            $data = $result['data'];

            return $data;

        } catch (\Exception $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }
    }
}
