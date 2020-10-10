<?php

declare(strict_types=1);

namespace EsQb\Query;

use function array_push;

final class IdsQuery extends AbstractQuery
{
    /** @var string[] */
    private array $ids = [];

    /**
     * @inheritDoc
     */
    protected function doToQuery(): array
    {
        $innerQuery = ['values' => $this->ids];
        $this->printBoostAndQueryName($innerQuery);

        return ['ids' => $innerQuery];
    }

    public function addIds(string ...$ids): void
    {
        array_push($this->ids, ...$ids);
    }

    /**
     * @return string[]
     */
    public function getIds(): array
    {
        return $this->ids;
    }
}
