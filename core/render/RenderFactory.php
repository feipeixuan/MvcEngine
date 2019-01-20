<?php

class RenderFactory
{
    public static function getRender($label){
        if(in_array($label['name'],array("if","else","elseif"))){
            return new BranchRender();
        }
        if(in_array($label['name'],array("for","foreach","while"))){
            return new LoopRender();
        }
        if(in_array($label['name'],array("echo","print"))){
            return new PrintRender();
        }
    }
}