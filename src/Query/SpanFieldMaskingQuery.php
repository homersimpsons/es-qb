<?php

declare(strict_types=1);

namespace EsQb\Query;

final class SpanFieldMaskingQuery extends AbstractQuery implements SpanQuery
{
    private SpanQuery $query;
    private string $field;

    public function __construct(SpanQuery $query, string $field)
    {
        $this->query = $query;
        $this->field = $field;
    }

    /**
     * @inheritDoc
     */
    protected function doToQuery(): array
    {
        $innerQuery = ['query' => $this->query->toQuery(), 'field' => $this->field];
        $this->printBoostAndQueryName($innerQuery);

        return ['field_masking_span' => $innerQuery];
    }
}
