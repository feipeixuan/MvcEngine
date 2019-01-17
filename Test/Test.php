<?php

require __DIR__ . "/../Config.php";
print_r(AnnotationParser::parseRouteInfo("PayController","purchaseGift"));
$compiler=new DefaultCompiler();
$compiler->setTemplate(__DIR__."/../Test/test.tpl");
$compiler->compile();
