<?php

declare(strict_types=1);

namespace EsQb\Unit\Query\FunctionScore;

use EsQb\Query\FunctionScore\RandomScoreFunction;
use PHPUnit\Framework\TestCase;
use stdClass;

class RandomScoreFunctionTest extends TestCase
{
    public const FULL_FUNCTION = [
        'random_score' => [
            'seed' => 42,
            'field' => '_seq_no',
        ],
    ];

    /**
     * @return array<string, mixed>
     */
    public static function baseFunction(): array
    {
        return ['random_score' => new stdClass()];
    }

    public function testBase(): void
    {
        $this->assertEquals(self::baseFunction(), (new RandomScoreFunction())->toFunction());
    }

    public function testWithAll(): void
    {
        $function = new RandomScoreFunction();
        $function->setSeed(42);
        $function->setField('_seq_no');
        $this->assertEquals(self::FULL_FUNCTION, $function->toFunction());
    }
}
