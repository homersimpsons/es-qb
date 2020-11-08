<?php

declare(strict_types=1);

namespace EsQb\Query\FunctionScore;

use EsQb\Query\AbstractQuery;

/**
 * @internal
 */
final class FunctionScoreFunction
{
    private AbstractScoreFunction $function;
    private float $weight;
    private ?AbstractQuery $filter;

    public function __construct(AbstractScoreFunction $function, float $weight, ?AbstractQuery $filter)
    {
        $this->function = $function;
        $this->weight   = $weight;
        $this->filter   = $filter;
    }

    public function getFunction(): AbstractScoreFunction
    {
        return $this->function;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function getFilter(): ?AbstractQuery
    {
        return $this->filter;
    }
}
