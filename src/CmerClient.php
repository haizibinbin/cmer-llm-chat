<?php

namespace Hbb\CmerLlmChat;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use Hbb\CmerLlmChat\models\ChatModel;

class CmerClient
{
    protected $headers = [];

    protected $host = 'https://api.cmer.com/v1/';

    /**
     * @var int 请求超时时间默认30秒
     */
    public int $timeout=60;


    public function __construct(string $apikey, int $timeout=60)
    {
        $this->headers['apikey'] = $apikey;
        $this->headers['X-CmerApi-Host'] = "llm-chat.p.cmer.com";
        $this->timeout=$timeout;
    }

    /**
     * @param string $endpoint
     * @param string $method
     * @param array $body
     * @param array $query
     * @return
     * @throws \GuzzleHttp\Exception\GuzzleException
     * 流式响应请求
     */
    public function http(string $endpoint, string $method, array $body = [], array $query = []): Response
    {
        $client = new Client([
            'base_uri' => $this->host,
            'timeout' => $this->timeout,
            'verify' => false
        ]);
        # 组装headers
        $options = [
            'headers' => $this->headers,
        ];
        # query：路径参数
        if ($query)
            $options['query'] = $query;
        # body：请求体参数
        if ($body)
            $options['json'] = $body;

        try {
            return $client->request($method, $endpoint, $options);
        } catch (RequestException $exception) {
            return new Response(500, [], $exception->getMessage());
        }
    }

    /**
     * @param string $endpoint
     * @param string $method
     * @param array $body
     * @param array $query
     * @return
     * @throws \GuzzleHttp\Exception\GuzzleException
     * 流式响应请求
     */
    public function http_stream(string $endpoint, string $method, array $body = [], array $query = [])
    {
        $client = new Client([
            'base_uri' => $this->host,
            'timeout' => $this->timeout,
            'verify' => false
        ]);
        # 组装headers
        $options = [
            'headers' => $this->headers,
        ];
        # query：路径参数
        if ($query)
            $options['query'] = $query;
        # body：请求体参数
        if ($body)
            $options['json'] = $body;

        $options['stream'] = true;

        try {
            return $client->request($method, $endpoint, $options);
        } catch (RequestException $exception) {
            return new Response(500, [], $exception->getMessage());
        }
    }


    /****************************************** 以下是所有路由，函数名即路由地址 *****************************************/
    public function chat(ChatModel $model)
    {
        if ($model->stream)
            return $this->http_stream(__FUNCTION__, 'POST', $model->toArray());
        else
            return $this->http(__FUNCTION__, 'POST', $model->toArray());
    }

}
