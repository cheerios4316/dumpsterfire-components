<?php

namespace DumpsterfireComponents\Renderer;

use DumpsterfireComponents\Component;
use DumpsterfireComponents\ComponentCache\ComponentDataObject;
use DumpsterfireComponents\ComponentCache\ComponentDataManager;
use DumpsterfireComponents\Exceptions\ComponentRendererException;

class ComponentRenderer
{
    protected ?Component $component = null;

    public function loadComponent(Component $component): self
    {
        $this->component = $component;

        return $this;
    }

    public function getHtmlContent(): string
    {
        $componentData = $this->getComponentData();

        return $this->getViewContent($componentData->getViewPath());
    }


    /**
     * @param Component $component
     * @return ComponentDataObject
     */
    protected function getComponentData(): ComponentDataObject
    {
        $component = $this->getComponent();

        $componentDataManager = ComponentDataManager::getInstance();

        return $componentDataManager->getComponentData($component);
    }

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

    protected function getComponent(): Component
    {
        if(!$this->component) {
            throw new ComponentRendererException("Cannot use ComponentRenderer without loading a component first!");
        }

        return $this->component;
    }
}