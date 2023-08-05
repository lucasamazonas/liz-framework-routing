<?php

declare(strict_types=1);

use App\Exception\DirectoryDoesNotExistException;
use App\Infra\RouteScraper;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class RouteScraperTest extends TestCase
{
    #[DataProvider('searchDirectoriesWithRouteMapping')]
    public function testQuantityOfRoutesGreaterThanZero(string $directory)
    {
        $routeScraper = new RouteScraper($directory);
        print_r(count($routeScraper->getRoutes()) . PHP_EOL);
        self::assertGreaterThan(0, count($routeScraper->getRoutes()));
    }

    public static function searchDirectoriesWithRouteMapping(): array
    {
        return [
            [__DIR__ . '/../src'],
            [__DIR__ . '/../src/'],
            [__DIR__ . '/../src/Controller'],
            [__DIR__ . '/../src/Controller/'],
        ];
    }

    #[DataProvider('fetchDirectoriesWithoutNoRoute')]
    public function testQuantityOfRoutesEqualZero(string $directory)
    {
        $routeScraper = new RouteScraper($directory);
        self::assertCount(0, $routeScraper->getRoutes());
    }

    public static function fetchDirectoriesWithoutNoRoute(): array
    {
        return [
            [__DIR__ . '/../src/Domain/'],
            [__DIR__ . '/../src/Exception/'],
            [__DIR__ . '/../src/Infra/'],
        ];
    }

    #[DataProvider('fetchDirectoriesWithoutNonexistent')]
    public function testDirectoryNonexistent(string $directory)
    {
        $this->expectException(DirectoryDoesNotExistException::class);
        $this->expectExceptionMessage("Directory {$directory} does not exist");
        new RouteScraper($directory);
    }

    public static function fetchDirectoriesWithoutNonexistent(): array
    {
        return [
            ['123456789'],
            ['qwertyuiop'],
            ['asdfghjklç'],
            ['zxcvbnm'],
        ];
    }
}