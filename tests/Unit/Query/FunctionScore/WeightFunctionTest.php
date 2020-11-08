<?php

declare(strict_types=1);

namespace EsQb\Unit\Query\FunctionScore;

use EsQb\Query\FunctionScore\WeightFunction;
use PHPUnit\Framework\TestCase;

class WeightFunctionTest extends TestCase
{
    public const FULL_FUNCTION = ['weight' => 12.7];

    public function testBase(): void
    {
        $this->assertEquals(
            ['weight' => 12.7],
            (new WeightFunction(12.7))->toFunction()
        );
    }

    public function testFullQuery(): void
    {
        $function = new WeightFunction(12.7);
        $this->assertEquals(self::FULL_FUNCTION, $function->toFunction());
    }
}
