<?php

declare(strict_types=1);

namespace EsQb\Query;

final class ConstantScoreQuery extends AbstractQuery
{
    private AbstractQuery $filter;

    public function __construct(AbstractQuery $filter)
    {
        $this->filter = $filter;
    }

    /**
     * @inheritDoc
     */
    protected function doToQuery(): array
    {
        $innerQuery = ['filter' => $this->filter->toQuery()];
        $this->printBoostAndQueryName($innerQuery);

        return ['constant_score' => $innerQuery];
    }
}
