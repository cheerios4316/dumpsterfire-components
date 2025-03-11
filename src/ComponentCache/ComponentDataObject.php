<?php

namespace DumpsterfireComponents\ComponentCache;

class ComponentDataObject
{
    protected ?string $classPath = null;
    protected ?string $view = null;
    protected ?string $js = null;
    protected ?string $css = null;

    public function hydrate(?string $classPath = null, ?string $view = null, ?string $js = null, ?string $css = null): self
    {
        $this->classPath = $classPath;
        $this->view = $view;
        $this->js = $js;
        $this->css = $css;

        return $this;
    }

    public function getClassPath(): ?string
    {
        return $this->classPath;
    }

    public function getViewPath(): ?string
    {
        return $this->view;
    }

    public function getJsPath(): ?string
    {
        return $this->js;
    }

    public function getCssPath(): ?string
    {
        return $this->css;
    }
}