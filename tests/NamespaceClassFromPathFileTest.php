<?php

declare(strict_types=1);

use Routing\Controller\ExempleController;
use Routing\Domain\Route;
use Routing\Infra\RouteScraper;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class NamespaceClassFromPathFileTest extends TestCase
{
    #[DataProvider('getPathFileExistingClasses')]
    public function testFetchNamespaceOfExistingClasses(string $realNamespace, string $pathFile): void
    {
        $namespace = getNamespaceFromFilePath($pathFile, false);
        self::assertEquals($realNamespace, $namespace);
    }

    public static function getPathFileExistingClasses(): array
    {
        return [
            [Route::class, __DIR__ . '/../src/Domain/Route.php'],
            [RouteScraper::class, __DIR__ . '/../src/Infra/RouteScraper.php'],
            [ExempleController::class, __DIR__ . '/../src/Controller/ExempleController.php'],
        ];
    }

    #[DataProvider('getPathFileInvalid')]
    public function testMustReturnNullWhenUsingInvalidPathFile(string $pathFileInvalid): void
    {
        $namespace = getNamespaceFromFilePath($pathFileInvalid);
        self::assertNull($namespace);
    }

    public static function getPathFileInvalid(): array
    {
        return [
            [__DIR__ . '/../src/Domain/1234567890.php'],
            [__DIR__ . '/../src/Infra/qwertyuiop.php'],
            [__DIR__ . '/../src/Controller/asdfghjklç.php'],
            [__DIR__ . '/../src/Controller/zxcvbnm,.;.php'],
        ];
    }
}