<?php

namespace App\Mylib;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class HocmaiRequest
{
    /**
     * @throws GuzzleException
     */
    static function doRequestV1($method, $uri, $params = [])
    {
        $client = new Client([
            'timeout' => 30,
            'verify' => false
        ]);

        $options = [
            'headers' => [
                'Accept' => 'application/json',
                'x-api-key' => config('api.API_HOCMAI_ORIGIN_TOKEN')
            ],
        ];

        if ($method == 'GET') {
            $options['query'] = $params;
        } else {
            $options['form_params'] = $params;
        }

        $response = $client->request($method, $uri, $options);

        return json_decode($response->getBody(), true);
    }

    /**
     * @throws GuzzleException
     */
    static function doRequestWithToken($method, $uri, $token, $params = [])
    {
        $client = new Client([
            'timeout' => 30,
            'verify' => false
        ]);

        $options = [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ],
        ];

        if ($method == 'GET') {
            $options['query'] = $params;
        } else {
            $options['form_params'] = $params;
        }

        $response = $client->request($method, $uri, $options);

        return json_decode($response->getBody(), true);
    }

    /**
     * @throws GuzzleException
     */
    static function doRequestV2($method, $uri, $params = [])
    {
        $client = new Client([
            'timeout' => 30,
            'verify' => false
        ]);

        $options = [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ];

        if ($method == 'GET') {
            $options['query'] = $params;
            $token = self::genToken($params);
        } else {
            $options['form_params'] = $params;
            $token = self::genToken();
        }

        $options['headers']['Authorization'] = 'Bearer ' . $token;

        $response = $client->request($method, $uri, $options);

        return json_decode($response->getBody(), true);
    }

    static function genToken($params = [])
    {
        $secret = config('api.API_HOCMAI_V2_SECRET');
        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256'
        ];
        $base64_header = base64_encode(json_encode($header));
        $base64_data = base64_encode(json_encode(config('api.API_HOCMAI_RANDOM_DATA')));
        $auth_sign = hash_hmac('sha256', $base64_header . $base64_data, $secret, true);
        $auth_sign = strtr(base64_encode($auth_sign), '+/', '-_');
        return ("$base64_header.$base64_data.$auth_sign");
    }
}
