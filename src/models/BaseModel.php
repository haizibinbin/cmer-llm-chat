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
        // 如果 $value 是空数组，或空字符串，则过滤掉
        return array_filter($vars, function($value) {
            // 只有当回调函数返回 true 时，元素才会保留在数组中。
            return !((is_array($value) || is_string($value)) && empty($value));
        });
    }
}
