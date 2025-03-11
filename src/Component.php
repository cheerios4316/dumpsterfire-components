<?php

namespace DumpsterfireComponents;

use DumpsterfireBase\Container\Container;
use DumpsterfireComponents\Interfaces\ISetup;
use DumpsterfireComponents\Renderer\ComponentRenderer;

abstract class Component
{
    public function render(): void
    {
        echo $this->content();
    }

    public function content(): string
    {
        $this->preRender();

        return Container::getInstance()->create(ComponentRenderer::class)->loadComponent($this)->getHtmlContent();
    }

    private function preRender(): void
    {
        if ($this instanceof ISetup) {
            $this->setup();
        }
    }
}