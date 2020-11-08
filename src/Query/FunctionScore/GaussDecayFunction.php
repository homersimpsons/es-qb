<?php

declare(strict_types=1);

namespace EsQb\Query\FunctionScore;

final class GaussDecayFunction extends AbstractDecayFunction
{
    protected function getDecayFunction(): string
    {
        return 'gauss';
    }
}
