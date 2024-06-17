<?php

namespace Hbb\CmerLlmChat\models;

/**
 * 重要提示：参数设置参考的 openai SDK 文档
 * https://platform.openai.com/docs/api-reference/chat/create
 */
class ChatModel extends BaseModel
{
    /**
     * @var array $messages
     * 聊天消息
     */
    public array $messages;

    /**
     * @var string $model
     * 模型名称
     */
    public string $model="gpt-3.5-turbo-0125";

    /**
     * @var string $supplier
     * 模型供应商
     */
    public string $supplier="azure";

    /**
     * @var bool $stream
     * 流式响应？
     */
    public bool $stream=false;


    /**
     * @var float|int $temperature
     * 介于 0 和 2 之间。
     * 较高的值（如 0.8）将使输出更加随机，而较低的值（如 0.2）将使其更加集中和确定性。
     * 我们通常建议更改此值或 top_p，但不要同时更改两者。
     */
    public int $temperature=0;

    /**
     * @var int $max_tokens
     * 限制回复的最大token数
     * 默认不限制
     */
    public int $max_tokens=0;

    /**
     * @var array $stop
     * openai 并行调用函数
     */
    public array $tools=[];

    /**
     * @var string $tool_choice
     * 指定函数调用
     * 不传值，或空，默认为auto：模型会自己选择调用哪些函数
     * 指定函数示例：{"type": "function", "function": {"name": "my_function"}}
     */
    public string $tool_choice='';

    /**
     * @var float $frequency_penalty
     * -2.0 和 2.0 之间的数字。正值根据迄今为止文本中的现有频率对新标记进行惩罚，从而降低模型逐字重复同一行的可能性.
     * 默认为0
     */
    public float $frequency_penalty=0;

    /**
     * @var string $response_format
     * 指定模型必须输出的格式。
     * 示例：{ "type": "json_object" }
     *
     * 重要提示：使用 JSON 模式时，您还必须通过系统或用户消息指示模型自行生成 JSON。
     * 如果不这样做，模型可能会生成无休止的空白流，直到生成达到令牌限制，从而导致请求长时间运行且看似“卡住”。
     * 另请注意，如果 finish_reason="length"，则消息内容可能会被部分截断，这表示生成超过了 max_tokens 或对话超过了最大上下文长度。
     */
    public string $response_format='';

    /**
     * @var bool $security_check
     * 安全审核，默认开启
     * 注意：当用国内的模型时，请记得关闭安全审核，国内模型自带了安全审核。以免造成资源浪费。
     */
    public bool $security_check=true;

    public function __construct(array $messages)
    {
        $this->messages = $this->filterMessage($messages);
    }

    /**
     * @param array $messages
     * @return array
     * 过滤Message里面的content 为  null的，转空字符
     */
    public function filterMessage(array $messages)
    {
        foreach ($messages as $key => $message) {
            if (empty($message['content'])) {
                $messages[$key]['content'] = '-';
            }
        }
        return $messages;
    }
}
