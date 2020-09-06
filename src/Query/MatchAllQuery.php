<?php

declare(strict_types=1);

namespace EsQb\Query;

final class MatchAllQuery extends AbstractQuery
{
    /**
     * @inheritDoc
     */
    protected function doToQuery(): array
    {
        $innerQuery = [];
        $this->printBoostAndQueryName($innerQuery);

        return ['match_all' => $innerQuery];
    }
}
