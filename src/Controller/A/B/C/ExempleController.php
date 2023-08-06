<?php

declare(strict_types = 1);

namespace Routing\Controller\A\B\C;

use Routing\Domain\Method;
use Routing\Domain\Route;

class ExempleController
{
    #[Route(uri: '/users', method: Method::GET)]
    public function index(): string
    {
        return "ola mundo";
    }

    #[Route(uri: '/users', method: Method::POST)]
    public function store(): string
    {
        return "ola mundo";
    }

    #[Route(uri: '/users', method: Method::PUT)]
    public function update(): string
    {
        return "ola mundo";
    }

    #[Route(uri: '/users/{id}', method: Method::GET)]
    public function show(int $id): string
    {
        return "ola mundo";
    }
}