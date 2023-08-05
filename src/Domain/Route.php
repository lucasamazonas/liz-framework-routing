<?php

declare(strict_types = 1);

namespace App\Domain;

use Attribute;

#[Attribute]
final class Route implements RouteInterface
{

    public function __construct(
        private string $path,
        private MethodEnum $method,
    )
    {}

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    public function getMethod(): MethodEnum
    {
        return $this->method;
    }

    public function setMethod(MethodEnum $method): void
    {
        $this->method = $method;
    }
}