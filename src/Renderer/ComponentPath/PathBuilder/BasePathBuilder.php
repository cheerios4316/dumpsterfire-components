<?php

namespace DumpsterfireComponents\Renderer\ComponentPath\PathBuilder;

abstract class BasePathBuilder implements PathBuilderInterface
{
    protected string $prefix = "";
    protected string $filetype = "";
    public function build(string $path): string
    {
        $pathData = pathinfo($path);

        $prefix = rtrim($this->prefix, ".") . ".";
        $filetype = "." . ltrim($this->filetype, ".");

        return $pathData["dirname"] . DIRECTORY_SEPARATOR . $prefix . $pathData["filename"] . $filetype;
    }
}