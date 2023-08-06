<?php

declare(strict_types = 1);

namespace Routing\Domain;

use Attribute;

#[Attribute]
final readonly class Route
{

    private string $originClass;

    private string $originClassMethod;

    public function __construct(
        public string    $uri,
        public Method $method,
    )
    {}

    public function setOriginClass(string $originClass): void
    {
        $this->originClass = $originClass;
    }

    public function getOriginClass(): string
    {
        return $this->originClass;
    }

    public function setOriginClassMethod(string $originClassMethod): void
    {
        $this->originClassMethod = $originClassMethod;
    }

    public function getOriginClassMethod(): string
    {
        return $this->originClassMethod;
    }
}