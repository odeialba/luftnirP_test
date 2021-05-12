<?php declare(strict_types=1);

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Printful\Service\CacheService;
use Printful\Service\PrintfulService;

class GetGuzzleClientTest extends TestCase
{
    public static function callMethod($obj, $name, array $args) {
        // Necessary to test protected methods
        $class = new ReflectionClass($obj);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method->invokeArgs($obj, $args);
    }

    public function testGetGuzzleClient(): void
    {
        self::assertInstanceOf(
            Client::class,
            self::callMethod(
                new PrintfulService(new CacheService()),
                'getGuzzleClient',
                []
            )
        );
    }
}
