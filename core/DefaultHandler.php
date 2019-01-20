<?php
/*
 * Description:请求的处理器
 * Author: feipeixuan
 */

class DefaultHandler
{
    private $router;

    private static $_instance = null;

    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new DefaultHandler();
        }
        return self::$_instance;
    }

    public function __construct()
    {
        $this->router = Router::getInstance();
    }

    // 处理请求
    public function service()
    {
        $ac = $_REQUEST['ac'];
        $methodType = $_SERVER['REQUEST_METHOD'] == 'GET' ? RouteInfo::GET_METHOD : RouteInfo::POST_METHOD;
        $controller = $this->router->getController($ac,$methodType);
        $controller->execute();
    }
}
