<?php


class Autoloader
{
    private static $autoloadPathArray = array(
        "controller",
        "exception",
        "util",
        "../app/controller",
        "../app/service",
        "DefaultHandler.php",
        "Router.php"
    );

    // TODO 未来要支持多级目录，暂时只支持二级目录
    public static function autoload()
    {
        foreach (self::$autoloadPathArray as $autoloadPath) {
            $autoloadPath = __DIR__ . "/../" . $autoloadPath;
            if (is_file($autoloadPath)) {
                $tmpArray = explode(".", $autoloadPath);
                if (end($tmpArray) == "php") {
                    require_once $autoloadPath;
                }
            } else {
                $fileList = scandir($autoloadPath);
                foreach ($fileList as $file) {
                    if ($file != ".." && $file != ".") {
                        $tmpArray = explode(".", $file);
                        if (end($tmpArray) == "php") {
                            require_once $autoloadPath."/".$file;
                        }
                    }
                }
            }
        }
    }

    public static function addAutoloadPath($path)
    {
        array_push(self::$autoloadPathArray, $path);
    }
}
