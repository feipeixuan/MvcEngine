<?php

abstract class Render
{
    public abstract function generateContent($label);

    public function generateVariable($variable)
    {
        return "\$valueStack[\"" . $variable . "\"]";
    }

    public function addPrefix($variable)
    {
        return "\$" . $variable;
    }
}

class BranchRender extends Render
{
    public function generateContent($label)
    {
        // TODO: Implement generateContent() method.
    }
}

class LoopRender extends Render
{
    public function generateContent($label)
    {
        if ($label['position'] == "postfix") {
            return " } ";
        }
        $prefix = $label['name'] . "(";
        $postfix = "){";
        // 仅支持for while foreach
        if ($label['name'] == "while" or $label == "for") {
            $content = $label['expression'];
        }
        if ($label['name'] == "foreach") {
            if (!isset($label['key'])) {
                $content = $this->generateVariable($label['values']) . " as " . $this->addPrefix($label['value']);
            } else {
                $content = $this->generateVariable($label['values']) . " as " . $this->addPrefix($label['key']) . " => " . $this->addPrefix($label['value']);
            }
        }
        return $prefix . $content . $postfix;
    }
}

class PrintRender extends Render
{
    public function generateContent($label)
    {
        return "echo " . $label['value'];
    }
}

