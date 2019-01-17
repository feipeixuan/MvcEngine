<?php
// 默认的编译工具类
class DefaultCompiler extends Compiler
{
    private $variables = array();

    private static $_id = 1;

    private static $_instance;

    public static function getInstance(){
        if(self::$_instance==null){
            self::$_instance=new DefaultCompiler();
        }
        return self::$_instance;
    }

    public function compile()
    {
        $labelArray = $this->parseTemplate();
        print_r($labelArray);
        if (!$this->validateTemplate($labelArray)) {
            throw XmlException("xml 文件语法错误");
        }
        $outFile = __DIR__ . "/../Tmp/" . self::$_id . ".php";
        //TODO 内容替换
        $outFile = fopen($outFile, "w");
        foreach ($labelArray as $label) {
            if (!is_array($label)) {
                fputs($outFile, $label);
            } else {
                fputs($outFile, $this->compileLabel($label));
            }
        }
        fclose($outFile);
    }

    public static function getId()
    {
        return self::$_id++;
    }

    public function compileLabel($label)
    {
        $prefix = "<?php ";
        $postfix = " ?>";
        $render = RenderFactory::getRender($label);
        $content = $render->generateContent($label);
        return $prefix . $content . $postfix . "\n";
    }

    // 解析模板文件
    public function parseTemplate()
    {
        $templateFile = fopen($this->templateFile, "r");
        $labelArray = array();
        while (!feof($templateFile)) {
            $content = fgets($templateFile);
            $label = XmlParser::convertToLabel($content);
            if ($label != 0) {
                $labelArray[] = $label;
            } else {
                $labelArray[] = $content;
            }
        }
        return $labelArray;
    }

    // 校验模板文件
    public function validateTemplate($labelArray)
    {
        // 基于栈结构进行校验
        $stack = array();
        foreach ($labelArray as $label) {
            if (is_array($label)) {
                // 单标签
                if ($label['type'] == "single") {
                    continue;
                }
                // 双标签
                if ($label['position'] == "prefix") {
                    array_push($stack, $label);
                } else {
                    if (end($stack)["name"] != $label['name']) {
                        return false;
                    }
                    array_pop($stack);
                }
            }
        }
        if (count($stack) == 0) {
            return true;
        }
        return false;
    }
}

