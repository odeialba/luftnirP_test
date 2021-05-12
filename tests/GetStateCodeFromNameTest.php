<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Printful\Entity\Country;
use Printful\Service\CacheService;
use Printful\Service\PrintfulService;

class GetStateCodeFromNameTest extends TestCase
{
    public function provider(): array
    {
        return [
            [
                'name' => 'North Carolina',
                'code' => 'NC'
            ],
            [
                'name' => 'Mississippi',
                'code' => 'MS'
            ],
            [
                'name' => 'Armed Forces Pacific',
                'code' => 'AP'
            ]
        ];
    }

    public static function callMethod($obj, $name, array $args) {
        // Necessary to test protected methods
        $class = new ReflectionClass($obj);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method->invokeArgs($obj, $args);
    }

    /**
     * @dataProvider provider
     * @param string $name
     * @param string $code
     */
    public function testGetStateCodeFromName(
        string $name,
        string $code
    ): void
    {
        $printfulService = $this->getMockBuilder(PrintfulService::class)
            ->setConstructorArgs([new CacheService()])
            ->disableOriginalConstructor()
            ->setMethods(['getCountries'])
            ->getMock();

        $cachedCountries = file_get_contents(__DIR__ . "/Fixtures/countries");

        $countries = [];
        foreach (json_decode($cachedCountries)->result as $resultCountry) {
            $country = new Country($resultCountry);
            $countries[] = $country;
        }

        $printfulService->expects(self::once())
            ->method('getCountries')
            ->willReturn($countries);

        $stateCode = self::callMethod(
            $printfulService,
            'getStateCodeFromName',
            [$name]
        );

        self::assertEquals($code, $stateCode);
    }
}
