<?php

namespace App\Domain;

interface RouteInterface
{
    public function getPath(): string;

    public function setPath(string $path): void;

    public function getMethod(): MethodEnum;

    public function setMethod(MethodEnum $method): void;
}