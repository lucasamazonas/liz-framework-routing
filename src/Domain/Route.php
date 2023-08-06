<?php

declare(strict_types = 1);

namespace Routing\Domain;

use Attribute;

#[Attribute]
final readonly class Route
{

    public function __construct(
        public string    $uri,
        public Method $method,
    )
    {}

}