<?php

namespace DumpsterfireComponents\PageTemplate;

use DumpsterfireBase\Container\Container;
use DumpsterfireComponents\Component;

class PageTemplate
{
    /** @var ?class-string<Component> $header */
    protected static ?string $header = null;

    /** @var ?class-string<Component> $footer */
    protected static ?string $footer = null;

    /**
     * @param class-string<Component> $header
     * @return void
     */
    public static function setHeader(string $header): void
    {
        self::$header = $header;
    }

    /**
     * @param class-string<Component> $footer
     * @return void
     */
    public static function setFooter(string $footer): void
    {
        self::$footer = $footer;
    }

    /**
     * @template T
     * @param class-string<Component> $class
     * @return Component
     */
    protected static function containerGet(string $class): Component
    {
        return Container::getInstance()->create($class);
    }

    public static function getHeaderComponent(): ?Component
    {
        if(self::$header) {
            return self::containerGet(self::$header);
        }

        return null;
    }

    public static function getFooterComponent(): ?Component
    {
        if(self::$footer) {
            return self::containerGet(self::$footer);
        }

        return null;
    }
}