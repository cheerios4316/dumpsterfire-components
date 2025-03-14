<?php

namespace DumpsterfireComponents\AssetsManager;

use DumpsterfireComponents\Exceptions\AssetsException;

class DefaultDependencies
{
    /**
     * @var array{'js': string[], 'css': string[]}
     */
    protected static array $default = [
        'js' => [
            '/repos/dumpsterfire-components/src/js/Application.js'
        ],
        'css' => []
    ];

    /**
     * @var string[] $allowedTypes
     */
    private static array $allowedTypes = ['js', 'css'];

    public static function get(): array
    {
        return self::$default;
    }

    public static function addJs(string $path): void
    {
        self::add($path, 'js');
    }

    public static function addCss(string $path): void
    {
        self::add($path, 'css');
    }

    protected static function add(string $path, string $type): void
    {
        try {
            self::protect($type);
        } catch (AssetsException $e) {
            // handle gracefully the wrong type of asset
            // @todo log somewhere graceful handlings
            return;
        }
        if (!in_array($path, self::$default[$type])) {
            self::$default[$type][] = $path;
        }
    }

    /**
     * @param string $type
     * @return void
     * @throws AssetsException
     */
    protected static function protect(string $type): void
    {
        if (!in_array($type, self::$allowedTypes)) {
            throw new AssetsException("Invalid asset type: $type");
        }
    }
}