<?php

// 基本类
class Controller
{
    // 值栈
    private $value;

    // 编译类
    private $compiler;

    public function __construct()
    {
        $this->compiler = DefaultCompiler::getInstance();
    }

    // 注入单个变量
    public function assign($key, $value)
    {
        $this->value[$key] = $value;
    }

    // 注入数组变量
    public function assignArray($array)
    {
        if (is_array($array)) {
            foreach ($array as $k => $v) {
                $this->value[$k] = $v;
            }
        }
    }

    public function getView()
    {
        $this->compiler->complie();
    }

    public function execute(){
        
    }
}