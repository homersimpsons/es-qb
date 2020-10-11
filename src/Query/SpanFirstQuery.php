<?php

declare(strict_types=1);

namespace EsQb\Query;

final class SpanFirstQuery extends AbstractQuery implements SpanQuery
{
    private SpanQuery $match;
    private int $end;

    public function __construct(SpanQuery $match, int $end)
    {
        $this->match = $match;
        $this->end   = $end;
    }

    /**
     * @inheritDoc
     */
    protected function doToQuery(): array
    {
        $innerQuery = ['match' => $this->match->toQuery(), 'end' => $this->end];
        $this->printBoostAndQueryName($innerQuery);

        return ['span_first' => $innerQuery];
    }
}
