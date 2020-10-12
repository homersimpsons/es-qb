<?php

declare(strict_types=1);

namespace EsQb\Query;

use EsQb\Utils;

use function array_map;
use function array_push;

final class SpanNearQuery extends AbstractQuery implements SpanQuery
{
    /** @var SpanQuery[] */
    private array $clauses;
    private int $slop;
    private ?bool $inOrder = null;

    public function __construct(SpanQuery $initialClause, int $slop)
    {
        $this->clauses = [$initialClause];
        $this->slop    = $slop;
    }

    /**
     * @inheritDoc
     */
    protected function doToQuery(): array
    {
        $innerQuery = [
            'clauses' => array_map(static fn (SpanQuery $clause) => $clause->toQuery(), $this->clauses),
            'slop' => $this->slop,
        ];
        $this->printBoostAndQueryName($innerQuery);
        Utils::printIfNotDefault($innerQuery, 'in_order', $this->getInOrder(), null);

        return ['span_near' => $innerQuery];
    }

    public function addClauses(SpanQuery ...$clauses): void
    {
        array_push($this->clauses, ...$clauses);
    }

    public function getInOrder(): ?bool
    {
        return $this->inOrder;
    }

    public function setInOrder(?bool $inOrder): void
    {
        $this->inOrder = $inOrder;
    }
}
