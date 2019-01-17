<?php 
// 模板编译工具类
abstract class Compiler
{
    //模板文件
	protected $templateFile;

    //编译方法
    public abstract function compile();

    public function setTemplate($templateFile){
        $this->templateFile=$templateFile;
    }

}