<?php

declare(strict_types=1);

namespace EsQb\Query\FunctionScore;

use EsQb\Utils;

final class FieldValueFactorFunction extends AbstractScoreFunction
{
    public const DEFAULT_FACTOR   = 1.;
    public const DEFAULT_MODIFIER = 'none';
    private string $field;
    private float $factor;
    private string $modifier;
    private ?float $missing;

    public function __construct(
        string $field,
        float $factor = self::DEFAULT_FACTOR,
        string $modifier = self::DEFAULT_MODIFIER,
        ?float $missing = null
    ) {
        $this->field    = $field;
        $this->factor   = $factor;
        $this->modifier = $modifier;
        $this->missing  = $missing;
    }

    /**
     * @inheritDoc
     */
    protected function doToFunction(): array
    {
        $innerFunction = ['field' => $this->field];
        Utils::printIfNotDefault($innerFunction, 'factor', $this->factor, self::DEFAULT_FACTOR);
        Utils::printIfNotDefault($innerFunction, 'modifier', $this->modifier, self::DEFAULT_MODIFIER);
        Utils::printIfNotDefault($innerFunction, 'missing', $this->missing, null);

        return ['field_value_factor' => $innerFunction];
    }
}
