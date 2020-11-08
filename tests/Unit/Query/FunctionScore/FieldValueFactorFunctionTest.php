<?php

declare(strict_types=1);

namespace EsQb\Unit\Query\FunctionScore;

use EsQb\Query\FunctionScore\FieldValueFactorFunction;
use PHPUnit\Framework\TestCase;

class FieldValueFactorFunctionTest extends TestCase
{
    public const FULL_FUNCTION = [
        'field_value_factor' => [
            'field' => 'test',
            'factor' => 1.2,
            'modifier' => 'log',
            'missing' => 0.7,
        ],
    ];

    public function testBase(): void
    {
        $this->assertEquals(
            ['field_value_factor' => ['field' => 'test']],
            (new FieldValueFactorFunction('test'))->toFunction()
        );
    }

    public function testFullQuery(): void
    {
        $function = new FieldValueFactorFunction('test', 1.2, 'log', 0.7);
        $this->assertEquals(self::FULL_FUNCTION, $function->toFunction());
    }
}
