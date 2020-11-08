<?php

declare(strict_types=1);

namespace EsQb\Query\FunctionScore;

use EsQb\Script;

final class ScoreFunctions
{
    private function __construct()
    {
    }

    public static function scriptScoreFunction(Script $script): ScriptScoreFunction
    {
        return new ScriptScoreFunction($script);
    }

    public static function weightFunction(float $weight): WeightFunction
    {
        return new WeightFunction($weight);
    }

    public static function randomScoreFunction(): RandomScoreFunction
    {
        return new RandomScoreFunction();
    }

    public static function fieldValueFactorFunction(
        string $field,
        float $factor = FieldValueFactorFunction::DEFAULT_FACTOR,
        string $modifier = FieldValueFactorFunction::DEFAULT_MODIFIER,
        ?float $missing = null
    ): FieldValueFactorFunction {
        return new FieldValueFactorFunction($field, $factor, $modifier, $missing);
    }

    public static function exponentialDecayFunction(
        string $field,
        string $scale,
        string $origin,
        ?string $offset = null,
        float $decay = AbstractDecayFunction::DEFAULT_DECAY
    ): ExponentialDecayFunction {
        return new ExponentialDecayFunction(
            $field,
            $scale,
            $origin,
            $offset,
            $decay
        );
    }

    public static function gaussDecayFunction(
        string $field,
        string $scale,
        string $origin,
        ?string $offset = null,
        float $decay = AbstractDecayFunction::DEFAULT_DECAY
    ): GaussDecayFunction {
        return new GaussDecayFunction(
            $field,
            $scale,
            $origin,
            $offset,
            $decay
        );
    }

    public static function linearDecayFunction(
        string $field,
        string $scale,
        string $origin,
        ?string $offset = null,
        float $decay = AbstractDecayFunction::DEFAULT_DECAY
    ): LinearDecayFunction {
        return new LinearDecayFunction(
            $field,
            $scale,
            $origin,
            $offset,
            $decay
        );
    }
}
