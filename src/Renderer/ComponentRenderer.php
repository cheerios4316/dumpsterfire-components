<?php

namespace DumpsterfireComponents\Renderer;

use DumpsterfireComponents\Component;
use DumpsterfireComponents\ComponentCache\ComponentDataObject;
use DumpsterfireComponents\ComponentCache\ComponentDataManager;
use DumpsterfireComponents\Exceptions\ComponentRendererException;

class ComponentRenderer
{
    protected ?Component $component = null;

    protected AssetsRenderer $assetsRenderer;

    public function __construct(AssetsRenderer $assetsRenderer)
    {
        $this->assetsRenderer = $assetsRenderer;
    }

    public function loadComponent(Component $component): self
    {
        $this->component = $component;

        return $this;
    }

    /**
     * @return string
     * @throws ComponentRendererException
     */
    public function getHtmlContent(): string
    {
        $componentData = $this->getComponentData();

        return $this->getViewContent($componentData->getViewPath());
    }


    /**
     * @return ComponentDataObject
     * @throws ComponentRendererException
     */
    protected function getComponentData(): ComponentDataObject
    {
        $component = $this->getComponent();

        $componentDataManager = ComponentDataManager::getInstance();

        return $componentDataManager->getComponentData($component);
    }

    /**
     * @param string $view
     * @return string
     * @throws ComponentRendererException
     */
    protected function getViewContent(string $view): string
    {
        $component = $this->getComponent();

        ob_start();

        $includeClosure = function () use ($view) {
            require $view;
        };

        $boundClosure = $includeClosure->bindTo($component, get_class($component));

        $boundClosure();

        return ob_get_clean();
    }

    /**
     * @throws ComponentRendererException
     */
    protected function getComponent(): Component
    {
        if(!$this->component) {
            throw new ComponentRendererException("Cannot use ComponentRenderer without loading a component first!");
        }

        return $this->component;
    }
}