<?php

declare(strict_types=1);

namespace EsQb\Unit\Query\FunctionScore;

use EsQb\Integration\EsQbIntegrationTest;
use EsQb\Query\FunctionScore\ExponentialDecayFunction;
use PHPUnit\Framework\TestCase;

class ExponentialDecayFunctionTest extends TestCase
{
    public const FULL_FUNCTION = [
        'exp' => [
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
            ['exp' => ['field' => ['scale' => '2km', 'origin' => '11,12']]],
            (new ExponentialDecayFunction('field', '2km', '11,12'))->toFunction()
        );
    }

    public function testWithAll(): void
    {
        $function = new ExponentialDecayFunction(EsQbIntegrationTest::GEO_POINT_FIELD, '2km', '11,12', '0km', 0.33);
        $this->assertEquals(self::FULL_FUNCTION, $function->toFunction());
    }
}
