<?php

namespace Hbb\CmerLlmChat\models;

class BaseModel
{
    /**
     * @return array
     * 将对象属性转换为数组，得到一个参数数组
     * 注意：如果参数是 空数组或空字符串，则过滤掉，请求的时候不需要提交
     */
    public function toArray() {
        $vars = get_object_vars($this);
        return array_filter($vars, function($value) {
            // 如果 $value 是空数组，或空字符串，则过滤掉
            if ((is_array($value) || is_string($value)) && empty($value)) {
                return false;
            }
            return $value;
        });
    }
}
