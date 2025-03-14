<?php

namespace DumpsterfireComponents\AssetsManager\AssetObjects;

class JsAsset extends BaseAsset
{
    public function content(): string
    {
        return "<script src=\"" . $this->path . "\"></script>";
    }
}