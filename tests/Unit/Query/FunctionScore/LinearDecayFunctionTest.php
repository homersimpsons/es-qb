<?php

declare(strict_types=1);

namespace EsQb\Unit\Query\FunctionScore;

use EsQb\Integration\EsQbIntegrationTest;
use EsQb\Query\FunctionScore\LinearDecayFunction;
use PHPUnit\Framework\TestCase;

class LinearDecayFunctionTest extends TestCase
{
    public const FULL_FUNCTION = [
        'linear' => [
            EsQbIntegrationTest::GEO_POINT_FIELD => [
                'scale' => '2km',
                'origin' => '11,12',
                'offset' => '0km',
                'decay' => 0.33,
            ],
        ],
    ];

    public function testBase(): void
    {
        $this->assertEquals(
            ['linear' => ['field' => ['scale' => '2km', 'origin' => '11,12']]],
            (new LinearDecayFunction('field', '2km', '11,12'))->toFunction()
        );
    }

    public function testWithAll(): void
    {
        $function = new LinearDecayFunction(EsQbIntegrationTest::GEO_POINT_FIELD, '2km', '11,12', '0km', 0.33);
        $this->assertEquals(self::FULL_FUNCTION, $function->toFunction());
    }
}
