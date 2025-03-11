<?php

namespace DumpsterfireComponents\ComponentCache;

use DumpsterfireBase\Container\Container;
use DumpsterfireBase\Interfaces\SingletonInterface;
use DumpsterfireComponents\Component;
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
        $componentDataObject = Container::getInstance()->create(ComponentDataObject::class);

        $obj = $componentDataObject->hydrate([
            "classPath" => $classPath,
            "view" => $viewPath,
            "js" => $js,
            "css" => $css
            ]
        );

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

    public function getJsPath(Component $component): ?string
    {
        return $this->getComponentData($component)?->getJsPath();
    }

    public function getCssPath(Component $component): ?string
    {
        return $this->getComponentData($component)?->getCssPath();
    }

    public static function getInstance(): self
    {
        if(!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}