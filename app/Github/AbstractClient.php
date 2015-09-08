<?php

namespace Github;


class AbstractClient
{
    protected $endpoint;

    private $method;

    private $url;

    private $token;

    private $params = [];

    private $httpClient;

    private $response;

    public function __construct()
    {
        $this->httpClient = new \GuzzleHttp\Client();
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param mixed $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * @return bool
     */
    private function hasParams()
    {
        return boolval(count($this->getParams()));
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param mixed $params
     */
    public function setParams($params)
    {
        $this->params = array_merge($this->params, $params);
    }

    /**
     * @return bool
     */
    private function hasToken()
    {
        return boolval($this->getToken());
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @param string $endpoint
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * @return mixed
     */
    protected function httpClient()
    {
        $method = $this->getMethod();
        $endpoint = $this->getEndpoint();
        $url = $this->getUrl();
        if ($this->hasToken()) {
            $this->setParams(['access_token' => $this->getToken()]);
        }
        $params = $this->getParams();

        if ($this->hasParams()) {
            $response = $this->httpClient->$method("{$endpoint}/{$url}", ['query' => $params]);
        } else {
            $response = $this->httpClient->$method("{$endpoint}/{$url}");
        }

        $this->setResponse($response);
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return mixed
     */
    public function toJson()
    {
        $this->httpClient();

        return $this->response->getBody();
    }

    /**
     * @return mixed
     */
    public function toArray()
    {
        $this->httpClient();

        return json_decode($this->response->getBody(), true);
    }
}