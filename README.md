# Cmer LLm Chat PHP SDK

> 创贸集团的LLM聊天服务PHP SDK  
> 负责发起聊天请求。  
> 请求参数参考文档地址：https://apihub.cmer.com/docs/llm-chat.html

## 安装

```shell
composer require hbb/cmer-llm-chat
```

## 使用

```php
<?php

require_once "vendor/autoload.php";

$apikey="xxxxxxxxxx";
$client = new \Hbb\CmerLlmChat\CmerClient($apikey);
# 修改超时时间，默认60秒
$client->timeout=300;
# 组装请求体参数
$messages = [
    ['role' => 'system', 'content' => "You are now the marketing customer service of 深圳创贸集团"],
    ['role' => 'user', 'content' => '创贸集团有多少技术？'],
    ['role' => 'assistant', 'content' => '创贸集团有200+技术。'],
    ['role' => 'user', 'content' => '今天天气怎么样']
];
$payload = new \Hbb\CmerLlmChat\models\ChatModel($messages);
# 修改模型名称,豆包，Gpt，Claude
# todo 更多参数请查看 \Hbb\CmerLlmChat\CmerClient 类
$payload->model = "gpt-3.5-turbo-0125";
$payload->supplier = "azure";
# 发送请求
$response = $client->chat($payload);
print_r($response->getBody()->getContents());

# 发送流式请求
$payload->stream = true;
$response = $client->chat($payload);
$body = $response->getBody();
while (!$body->eof()) {
    echo $body->read(1024);
}
```
