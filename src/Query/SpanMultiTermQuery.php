<?php

declare(strict_types=1);

namespace EsQb\Query;

final class SpanMultiTermQuery extends AbstractQuery implements SpanQuery
{
    private MultiTermQuery $multiTermQuery;

    public function __construct(MultiTermQuery $multiTermQuery)
    {
        $this->multiTermQuery = $multiTermQuery;
    }

    /**
     * @inheritDoc
     */
    protected function doToQuery(): array
    {
        $innerQuery = ['match' => $this->multiTermQuery->toQuery()];
        $this->printBoostAndQueryName($innerQuery);

        return ['span_multi' => $innerQuery];
    }
}
