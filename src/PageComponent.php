<?php

namespace DumpsterfireComponents;

use DumpsterfireBase\Container\Container;
use DumpsterfireComponents\Interfaces\RendererInterface;
use DumpsterfireComponents\PageTemplate\PageTemplate;
use DumpsterfireComponents\Renderer\PageRenderer;

class PageComponent extends Component
{
    protected function getComponentRenderer(): RendererInterface
    {
        return Container::getInstance()->create(PageRenderer::class);
    }
}