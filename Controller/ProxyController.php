<?php

// 代理的Controller
class ProxyController extends Controller
{
    private $controllerName;

    private $methodName;

    private $instance;

    public function __construct($controllerName,$methodName,$instance)
    {
        $this->controllerName=$controllerName;
        $this->methodName=$methodName;
        $this->instance=$instance;
    }

    public function execute()
    {
        $class = new ReflectionClass($this->controllerName);
        $method = $class->getmethod($this->methodName);
        return $method->invoke($this->instance);
    }
}