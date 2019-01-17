<?php

// Xml工具类
class XmlParser
{
    private static $labelArray = array();

    public static function convertToLabel($content)
    {
        // 获取预定义的标签
        if (self::$labelArray == null) {
            self::getLabels();
        }
        $labelPosition = "prefix";
        preg_match_all("/<s:(.*)>/", $content, $matchs);
        if (count($matchs[0]) == 0) {
            preg_match_all("/<\/s:(\S*)>/", $content, $matchs);
            $labelPosition = "postfix";
        }
        // 没有匹配到的情况
        if (count($matchs[0]) == 0)
            return 0;
        $content = $matchs[1][0];
        $labelName = explode(" ", $content)[0];
        $currentLabel = array();
        $currentLabel['name'] = $labelName;
        $currentLabel['position'] = $labelPosition;
        // 非前缀
        if($labelPosition!="postfix") {
            // TODO 匹配标签
            foreach (self::$labelArray as $label) {
                if ($label->labelName == $labelName) {
                    // TODO 约束判断 + 赋值
                    foreach ($label->keywords as $keyword => $property) {
                        if ($keyword == $labelName) {
                            continue;
                        }
                        if ($keyword == "type") {
                            $currentLabel['type'] = $property;
                            continue;
                        }
                        $value = self::parseValue($content, $keyword);
                        // 约束判断
                        if ($value == null && $property == Label::$TYPE_MUST) {
                            echo $keyword;
                            throw XmlException($labelName . ":" . $keyword . " must have value");
                        } else {
                            if ($value != null) {
                                $currentLabel[$keyword] = $value;
                            }
                        }
                    }
                }
            }
        }else{
            $currentLabel['type'] = "double";
        }
        return $currentLabel;
    }

    // 获取已定义好的标签
    public static function getLabels()
    {
        $xmlInfo = (array)simplexml_load_file(__DIR__ . "/../Labels/config.xml");
        $jsonInfo = json_encode($xmlInfo, JSON_UNESCAPED_UNICODE);
        $labelConfig = json_decode($jsonInfo, true);

        foreach ($labelConfig['label'] as $label) {
            $label = new Label($label);
            self::$labelArray[] = $label;
        }
    }

    // 解析值
    public static function parseValue($content, $keyword)
    {
        //支持引号的内容
        preg_match_all("/$keyword\s*=\s*\"(\S*)\"/", $content, $matchs);
        if(count($matchs[1])==0)
            return 0;
        return $matchs[1][0];
    }

}



