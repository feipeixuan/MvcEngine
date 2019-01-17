<?php

class AnnotationParser
{
    // 获取路由相关的信息
    public static function parseRouteInfo($controllerName, $methodName)
    {
        $reflectClass = new ReflectionClass($controllerName);
        $annotation = $reflectClass->getMethod($methodName)->getDocComment();
        preg_match_all("/@Route\((.*)\)/", $annotation, $matchs);
        if (count($matchs) < 1 or count($matchs[1]) < 1) {
            return false;
        }
        $routeContent = $matchs[1][0];
        $routeInfo = new RouteInfo();
        $routeInfo->ac = self::parseValue($routeContent, "ac");
        $methodType = self::parseValue($routeContent, "method");
        switch ($methodType) {
            case "post":
                $routeInfo->methodType = RouteInfo::POST_METHOD;
                break;
            case "get":
                $routeInfo->methodType = RouteInfo::GET_METHOD;
                break;
            case "all":
                $routeInfo->methodType = RouteInfo::ALL_METHOD;
                break;
        }
        return $routeInfo;
    }

    // 解析值
    public static function parseValue($content, $keyword)
    {
        //支持引号的内容
        $subStrs = explode(",", $content);
        foreach ($subStrs as $subStr) {
            preg_match_all("/$keyword\s*=\s*\"(\S*)\"\s*/", $subStr, $matchs);
            if (count($matchs) > 0 and count($matchs[1]) != 0)
                return $matchs[1][0];
        }
        return false;
    }
}



