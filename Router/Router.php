<?php

/*
 * Description:路由选择器
 * Author: feipeixuan
 */

class RouteInfo
{
    public $ac;

    public $methodType;

    const GET_METHOD = 0;

    const POST_METHOD = 1;

    const ALL_METHOD = 2;
}

class Router
{
    private static $_instance = null;

    private $routeInfos = array();

    private $controllers = array();

    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new Router();
        }
        return self::$_instance;
    }

    private function __construct()
    {
        // 建立映射关系表
        $fileList = scandir(__DIR__ . "/../Controller");
        foreach ($fileList as $file) {
            if ($file != ".." && $file != ".") {
                $tmpArray = explode(".", $file);
                if (end($tmpArray) != "php") {
                    continue;
                }
                $className = $tmpArray[0];
                if ($className == "Controller" || $className == "ProxyController") {
                    continue;
                }
                $parentClassName = get_parent_class($className);
                if ($parentClassName == "Controller") {
                    $class = new ReflectionClass($className);
                    $instance = $class->newInstance();
                    $methods = $class->getMethods();
                    foreach ($methods as $method) {
                        $methodName = $method->name;
                        $routeInfo = AnnotationParser::parseRouteInfo($className, $methodName);
                        if ($routeInfo != false) {
                            $ac = $routeInfo->ac;
                            $this->routeInfos[$ac] = $routeInfo;
                            $this->controllers[$ac] = new ProxyController($className, $methodName, $instance);
                        }
                    }
                }
            }
        }
    }


    public function findController($ac, $methodType)
    {
        if (!isset($this->routeInfos[$ac])) {
            throw new RouteException("not find controller");
        }
        $routeInfo = $this->routeInfos[$ac];
        if ($routeInfo->methodType != $methodType && $routeInfo->methodType != RouteInfo::ALL_METHOD) {
            throw new RouteException("controller not support this method");
        }
        $controller = $this->controllers[$ac];
        return $controller;
    }

    public function show()
    {
        print_r($this->routeInfos);
    }
}