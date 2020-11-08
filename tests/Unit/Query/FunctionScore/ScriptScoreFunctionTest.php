<?php

declare(strict_types=1);

namespace EsQb\Unit\Query\FunctionScore;

use EsQb\Query\FunctionScore\ScriptScoreFunction;
use EsQb\Script;
use PHPUnit\Framework\TestCase;

class ScriptScoreFunctionTest extends TestCase
{
    public const FULL_FUNCTION = [
        'script_score' => [
            'script' => ['lang' => 'expression', 'source' => 'multiplier', 'params' => ['multiplier' => 2]],
        ],
    ];

    public function testBase(): void
    {
        $this->assertEquals(
            ['script_score' => ['script' => []]],
            (new ScriptScoreFunction(new Script()))->toFunction()
        );
    }

    public function testFullQuery(): void
    {
        $script = new Script();
        $script->setLang('expression');
        $script->setSource('multiplier');
        $script->setParams(['multiplier' => 2]);
        $function = new ScriptScoreFunction($script);
        $this->assertEquals(self::FULL_FUNCTION, $function->toFunction());
    }
}
