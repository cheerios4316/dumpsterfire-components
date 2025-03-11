<?php

namespace DumpsterfireComponents\Container;

interface SingletonInterface
{
    public static function getInstance(): self;
}