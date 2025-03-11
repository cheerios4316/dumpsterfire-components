<?php

namespace DumpsterfireComponents\Renderer;

use DumpsterfireComponents\Component;
use DumpsterfireComponents\ComponentCache\ComponentDataManager;

class ComponentPath
{
    public static function getDefinitionPath(Component $component): string
    {
        $reflector = new \ReflectionClass($component);
        return $reflector->getFileName();
    }
    public static function getViewPath(Component $component): string
    {
        $path = self::getDefinitionPath($component);
        
        $dirname = dirname($path);
        $basename = basename($path);

        return $dirname . DIRECTORY_SEPARATOR . 'view.' . $basename;
    }

    public static function getJsPath(Component $component): string
    {
        $path = self::getDefinitionPath($component);

        $pathData = pathinfo($path);

        return $pathData["dirname"] . DIRECTORY_SEPARATOR . "script." . $pathData["filename"] . ".js";
    }

    public static function getCssPath(Component $component): string
    {
        $path = self::getDefinitionPath($component);

        $pathData = pathinfo($path);

        return $pathData["dirname"] . DIRECTORY_SEPARATOR . "style." . $pathData["filename"] . ".css";
    }
}