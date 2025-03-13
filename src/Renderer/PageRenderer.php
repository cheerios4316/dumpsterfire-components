<?php

namespace DumpsterfireComponents\Renderer;

use DumpsterfireBase\Container\Container;
use DumpsterfireComponents\Component;
use DumpsterfireComponents\Exceptions\PageRendererException;
use DumpsterfireComponents\Interfaces\RendererInterface;
use DumpsterfireComponents\PageComponent;
use DumpsterfireComponents\PageTemplate\FlexComponent\FlexComponent;
use DumpsterfireComponents\PageTemplate\PageTemplate;

class PageRenderer implements RendererInterface
{
    protected ?PageComponent $component = null;
    protected ComponentRenderer $componentRenderer;
    protected Container $container;

    public function __construct(ComponentRenderer $componentRenderer, Container $container)
    {
        $this->componentRenderer = $componentRenderer;
        $this->container = $container;
    }

    /**
     * @param PageComponent $component
     * @return RendererInterface
     * @throws PageRendererException
     */
    public function loadComponent(Component $component): RendererInterface
    {
        if(!$component instanceof PageComponent) {
            throw new PageRendererException('PageRenderer expects a PageComponent.');
        }

        $this->component = $component;

        return $this;
    }

    /**
     * @return string
     * @throws PageRendererException
     */
    public function getHtmlContent(): string
    {
        if(!$this->component) {
            throw new PageRendererException('No PageComponent loaded.');
        }

        $templateHeader = PageTemplate::getHeaderComponent();
        $templateFooter = PageTemplate::getFooterComponent();

        $components = [$templateHeader, $this->component, $templateFooter];
        $data = array_filter($components, fn($elem) => $elem !== null);

        $flexComponent = $this->container->create(FlexComponent::class)->setItems($data);

        return $flexComponent->content();
    }
}