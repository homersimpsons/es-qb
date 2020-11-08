<?php

declare(strict_types=1);

namespace EsQb\Unit\Query\FunctionScore;

use Error;
use EsQb\Query\FunctionScore\ExponentialDecayFunction;
use EsQb\Query\FunctionScore\FieldValueFactorFunction;
use EsQb\Query\FunctionScore\GaussDecayFunction;
use EsQb\Query\FunctionScore\LinearDecayFunction;
use EsQb\Query\FunctionScore\RandomScoreFunction;
use EsQb\Query\FunctionScore\ScoreFunctions;
use EsQb\Query\FunctionScore\ScriptScoreFunction;
use EsQb\Query\FunctionScore\WeightFunction;
use EsQb\Script;
use PHPUnit\Framework\TestCase;

class ScoreFunctionsTest extends TestCase
{
    public function testCannotConstruct(): void
    {
        $this->expectException(Error::class);
        new ScoreFunctions();
    }

    public function testReturnRightClass(): void
    {
        $this->assertInstanceOf(ScriptScoreFunction::class, ScoreFunctions::scriptScoreFunction(new Script()));
        $this->assertInstanceOf(WeightFunction::class, ScoreFunctions::weightFunction(12.7));
        $this->assertInstanceOf(RandomScoreFunction::class, ScoreFunctions::randomScoreFunction());
        $this->assertInstanceOf(FieldValueFactorFunction::class, ScoreFunctions::fieldValueFactorFunction('field'));
        $this->assertInstanceOf(
            ExponentialDecayFunction::class,
            ScoreFunctions::exponentialDecayFunction('field', '2km', '11,12')
        );
        $this->assertInstanceOf(
            GaussDecayFunction::class,
            ScoreFunctions::gaussDecayFunction('field', '2km', '11,12')
        );
        $this->assertInstanceOf(
            LinearDecayFunction::class,
            ScoreFunctions::linearDecayFunction('field', '2km', '11,12')
        );
    }
}
