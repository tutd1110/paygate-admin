<?php

namespace App\Api;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class Api
{
    private $request;

    private $method = 'get';

    private $header = [];

    private $param;

    private $body;

    protected $url;

    protected $patch;

    /***
     * @var $response ResponseInterface
     */
    protected $response;

    protected $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGktbGRwLmhvY21haS52biIsImlhdCI6MTY0NTA5MDU5NSwiZXhwIjoxOTI4OTE0NTk1LCJuYmYiOjE2NDUwOTA1OTUsImp0aSI6IkMyRkJsNW5uWVBCTGtsQWsiLCJzdWIiOjEsInBydiI6IjJhYTYzOWRhMDk0YTY2OGE0ODRkZGUyZGY3NjRiOTg4Njk5MTI0OTYiLCJ0b2tlbiI6InNPMkVIaTMzaVZLcVpCR28ifQ._ScV05jMh2iQ4sdxa-RqQCwjrmq89cE6J21OM7ImwVE';

    public function __construct()
    {

        $this->request = new Client();
        $this->url = env('HOCMAI_API_V2','https://api-ldp.hocmai.vn');
    }

    public function setHeader($key, $value)
    {
        $this->header[$key] = $value;

        return $this;
    }

    public function setParams($param)
    {
        $this->param = $param;

        return $this;
    }

    public function get()
    {
        $this->makeRequest('GET');

        return $this;
    }

    public function post()
    {
        $this->makeRequest('POST');

        return $this;
    }

    public function makeRequest($method = 'GET')
    {
        $this->method = $method;

        $options = [
            'query' => $this->param,
        ];

        if ($this->token) {
            $options['headers']['token'] = $this->token;
        }

        \Barryvdh\Debugbar\Facade::startMeasure('api_call', 'api '.$this->patch);
        /***
         * ResponseInterface
         */
        $this->response = $this->request->request($this->method, $this->url.$this->patch, $options);
        $this->body = $this->response->getBody()->getContents();
        \Barryvdh\Debugbar\Facade::addMessage([
            'request' => $this->response->getStatusCode(),
            'api' => $this->url.$this->patch,
            'param' => $this->param,
            'body' => $this->response->getBody()->getContents()
        ], 'api_call_message');

        \Barryvdh\Debugbar\Facade::stopMeasure('api_call');


        return $this;
    }

    public function getResponseJson()
    {

        return json_decode((string)$this->response->getBody());
    }

    public function getData($filter)
    {
        $res = $this->setParams($filter)
            ->makeRequest('GET');

        try {
            $data = $res->getResponseJson();

            if ($data->status != 'success') {
                throw new \Exception('API HOCMAI ERROR: '.(string)$this->response->getBody(), '305');
            }
        } catch (\Exception $exception) {
            var_dump((string)$res->response->getBody());
        }


        return $data;
    }
}
