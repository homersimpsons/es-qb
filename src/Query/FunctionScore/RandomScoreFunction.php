<?php

declare(strict_types=1);

namespace EsQb\Query\FunctionScore;

use EsQb\Utils;
use stdClass;

final class RandomScoreFunction extends AbstractScoreFunction
{
    private ?int $seed     = null;
    private ?string $field = null;

    public function getSeed(): ?int
    {
        return $this->seed;
    }

    public function setSeed(?int $seed): void
    {
        $this->seed = $seed;
    }

    public function getField(): ?string
    {
        return $this->field;
    }

    public function setField(?string $field): void
    {
        $this->field = $field;
    }

    /**
     * @return array<string, mixed>
     */
    protected function doToFunction(): array
    {
        $innerQuery = [];
        Utils::printIfNotDefault($innerQuery, 'seed', $this->seed, null);
        Utils::printIfNotDefault($innerQuery, 'field', $this->field, null);
        if ($innerQuery === []) {
            return ['random_score' => new stdClass()];
        }

        return ['random_score' => $innerQuery];
    }
}
