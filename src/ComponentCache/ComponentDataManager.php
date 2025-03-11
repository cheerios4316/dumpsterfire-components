<?php

namespace DumpsterfireComponents\ComponentCache;

use DumpsterfireComponents\Component;
use DumpsterfireComponents\ComponentCache\ComponentDataObject;
use DumpsterfireComponents\Container\Container;
use DumpsterfireComponents\Container\SingletonInterface;
use DumpsterfireComponents\Renderer\ComponentPath;

class ComponentDataManager implements SingletonInterface
{
    /**
     * @var ComponentDataObject[];
     */
    protected array $cached = [];

    protected static ?self $instance = null;

    private function __construct() {}

    public function save(Component $component, ComponentDataObject $componentCacheObject): self
    {
        $this->cached[$component::class] = $componentCacheObject;

        return $this;
    }

    public function createAndSave(Component $component, ?string $classPath = null, ?string $viewPath = null, ?string $js = null, ?string $css = null): ComponentDataObject
    {
        $obj = Container::getInstance()->create(ComponentDataObject::class)->hydrate($classPath, $viewPath, $js, $css);

        $this->save($component, $obj);

        return $obj;
    }

    public function getComponentData(Component $component): ?ComponentDataObject
    {
        $data = $this->cached[$component::class] ?? null;

        if($data) {
            return $data;
        }

        $path = ComponentPath::getDefinitionPath($component);
        $view = ComponentPath::getViewPath($component);
        $js = ComponentPath::getJsPath($component);
        $css = ComponentPath::getCssPath($component);

        return $this->createAndSave($component, $path, $view, $js, $css);
    }

    public function getViewPath(Component $component): ?string
    {
        return $this->getComponentData($component)?->getViewPath();
    }

    public function getClassPath(Component $component): ?string
    {
        return $this->getComponentData($component)?->getClassPath();
    }

    public static function getInstance(): self
    {
        if(!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}