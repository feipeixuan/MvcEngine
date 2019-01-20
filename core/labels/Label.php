<?php

class Label
{
    public $labelName;

    public $keywords = array();

    public static $TYPE_OPTION = 1;

    public static $TYPE_MUST = 0;

    function __construct($label)
    {
        $this->labelName = $label['name'];
        foreach ($label as $key => $value) {
            if ($key == "name") {
                continue;
            } else {
                if ($value == "*") {
                    $this->assignKeyword($key, Label::$TYPE_MUST);
                } else {
                    $this->assignKeyword($key, Label::$TYPE_OPTION);
                }
            }
        }
        if(array_key_exists('type',$label)){
            $this->assignKeyword("type",$label["type"]);
        }else{
            $this->assignKeyword("type","double");
        }
    }

    function assignKeyword($keyword, $type)
    {
        $this->keywords[$keyword] = $type;
    }
}