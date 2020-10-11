<?php

declare(strict_types=1);

namespace EsQb\Query;

use function array_map;
use function array_push;

final class SpanOrQuery extends AbstractQuery implements SpanQuery
{
    /** @var SpanQuery[] */
    private array $clauses;

    public function __construct(SpanQuery $initialClause)
    {
        $this->clauses = [$initialClause];
    }

    /**
     * @inheritDoc
     */
    protected function doToQuery(): array
    {
        $innerQuery = [
            'clauses' => array_map(static fn (SpanQuery $clause) => $clause->toQuery(), $this->clauses),
        ];
        $this->printBoostAndQueryName($innerQuery);

        return ['span_or' => $innerQuery];
    }

    public function addClauses(SpanQuery ...$clauses): void
    {
        array_push($this->clauses, ...$clauses);
    }
}
