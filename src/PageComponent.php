<?php

namespace DumpsterfireComponents;

use DumpsterfireBase\Container\Container;
use DumpsterfireComponents\Interfaces\RendererInterface;
use DumpsterfireComponents\Renderer\PageRenderer;

class PageComponent extends Component
{
    /**
     * @var array<string, string> $meta
     */
    protected array $meta = [];
    protected string $title = '';
    protected string $lang = 'en';

    protected function getComponentRenderer(): RendererInterface
    {
        return Container::getInstance()->create(PageRenderer::class);
    }

    public function getMeta(): array
    {
        return $this->meta;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getLang(): string
    {
        return $this->lang;
    }
}