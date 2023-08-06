<?php

declare(strict_types = 1);

namespace Routing\Infra;

use Routing\Domain\Route;
use Routing\Exception\DirectoryDoesNotExistException;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class RouteScraper
{
    /** @var Route[] $routes */
    protected array $routes = [];

    /**
     * @throws ReflectionException
     * @throws DirectoryDoesNotExistException
     */
    public function __construct(
        protected string $directory
    )
    {
        if (! is_dir($this->directory)) {
            throw new DirectoryDoesNotExistException("Directory {$this->directory} does not exist");
        }

        $this->loadingRoutes();
    }

    /** @return Route[] */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * @throws ReflectionException
     */
    protected function loadingRoutes(): void
    {
        foreach ($this->getClassNamesDir() as $className) {
            array_push($this->routes, ...$this->getRoutesClass($className));
        }
    }

    protected function getClassNamesDir(): array
    {
        $namespaces = [];

        foreach ($this->fetchPhpFilesInDirectory($this->directory) as $file) {
            $namespace = getNamespaceFromFilePath($file);
            if (is_null($namespace)) continue;
            require_once $file;
//            if (!class_exists($namespace)) continue;
            $namespaces[] = $namespace;
        }

        return $namespaces;
    }

    public function fetchPhpFilesInDirectory(string $directory): array
    {
        $files = [];
        $filesDirectory = glob($directory . '*', GLOB_MARK);

        foreach ($filesDirectory as $item) {
            if (! is_file($item)) {
                array_push($files, ...$this->fetchPhpFilesInDirectory($item));
                continue;
            }
            if (pathinfo($item, PATHINFO_EXTENSION) !== 'php') continue;
            $files[] = $item;
        }

        return $files;
    }

    /**
     * @return Route[]
     * @throws ReflectionException
     */
    protected function getRoutesClass(string $class): array
    {
        $routesClass = [];
        $reflectionClass = new ReflectionClass($class);

        foreach ($reflectionClass->getMethods() as $method) {
            $routeClass = $this->getRouteMethod($method);
            if (is_null($routeClass)) continue;
            $routesClass[] = $routeClass;
        }

        return $routesClass;
    }

    /**
     * @param ReflectionMethod $reflectionMethod
     * @return null|Route
     */
    protected function getRouteMethod(ReflectionMethod $reflectionMethod): ?Route
    {
        foreach ($reflectionMethod->getAttributes() as $attribute) {
            $instance = $attribute->newInstance();
            if (! $instance instanceof Route) continue;
            return $instance;
        }

        return null;
    }
}
