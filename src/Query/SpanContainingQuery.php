<?php

declare(strict_types=1);

namespace EsQb\Query;

final class SpanContainingQuery extends AbstractQuery implements SpanQuery
{
    private SpanQuery $big;
    private SpanQuery $little;

    public function __construct(SpanQuery $big, SpanQuery $little)
    {
        $this->big    = $big;
        $this->little = $little;
    }

    /**
     * @inheritDoc
     */
    protected function doToQuery(): array
    {
        $innerQuery = [
            'big' => $this->big->toQuery(),
            'little' => $this->little->toQuery(),
        ];
        $this->printBoostAndQueryName($innerQuery);

        return ['span_containing' => $innerQuery];
    }
}
