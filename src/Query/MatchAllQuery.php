<?php

declare(strict_types=1);

namespace EsQb\Query;

use stdClass;

final class MatchAllQuery extends AbstractQuery
{
    /**
     * @inheritDoc
     */
    protected function doToQuery(): array
    {
        $innerQuery = [];
        $this->printBoostAndQueryName($innerQuery);
        if ($innerQuery === []) {
            $innerQuery = new stdClass();
        }

        return ['match_all' => $innerQuery];
    }
}
