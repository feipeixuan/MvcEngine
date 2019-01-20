<?php

// Label设置异常
class LabelException extends Exception
{
    public function __construct($message = "", Throwable $previous = null)
    {
        parent::__construct("label type error", 0, $previous);
    }
}