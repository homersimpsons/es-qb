<?php

declare(strict_types=1);

namespace EsQb\Query\FunctionScore;

final class WeightFunction extends AbstractScoreFunction
{
    private float $weight;

    public function __construct(float $weight)
    {
        $this->weight = $weight;
    }

    /**
     * @inheritDoc
     */
    protected function doToFunction(): array
    {
        return ['weight' => $this->weight];
    }
}
