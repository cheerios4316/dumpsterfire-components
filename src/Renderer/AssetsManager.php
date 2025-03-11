<?php

namespace DumpsterfireComponents\Renderer;

class AssetsManager
{
    protected static array $jsAssets = [];
    protected static array $cssAssets = [];

    /**
     * @param string $path
     * @return $this
     */
    public function loadJs(string $path): self
    {
        if(!in_array($path, self::$jsAssets)) {
            self::$jsAssets[] = $path;
        }

        return $this;
    }

    /**
     * @param string $path
     * @return $this
     */
    public function loadCss(string $path): self
    {
        if(!in_array($path, self::$cssAssets)) {
            self::$cssAssets[] = $path;
        }

        return $this;
    }

    public function getJsAssets(): array
    {
        return self::$jsAssets;
    }

    public function getCssAssets(): array
    {
        return self::$cssAssets;
    }
}