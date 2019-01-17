<?php

require __DIR__."/Autoloader/Autoloader.php";

class Config{

    public static $_instance = null;

    public  $arrayConfig = array(
        'suffix' 		=> '.tpl',		//模板的后缀
        'templateDir' 	=> 'template/', //模板所在的文件夹
        'compileDir'	=> 'cache/',	//编译后存放的目录
        'needCache'     =>  false       //默认不需要缓存
    );

    public static function getInstance(){
        if(self::$_instance==null){
            self::$_instance=new Config();
        }
        return self::$_instance;
    }
}

Autoloader::autoload();