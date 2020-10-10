<?php

declare(strict_types=1);

namespace EsQb\Query;

use function array_map;
use function array_push;

final class DisMaxQuery extends AbstractQuery
{
    public const TIE_BREAKER = 0.0;

    /** @var AbstractQuery[] */
    private array $queries    = [];
    private float $tieBreaker = self::TIE_BREAKER;

    /**
     * @inheritDoc
     */
    protected function doToQuery(): array
    {
        $innerQuery = ['queries' => array_map(static fn (AbstractQuery $query) => $query->doToQuery(), $this->queries)];
        $this->printBoostAndQueryName($innerQuery);
        $this->printIfNotDefault($innerQuery, 'tie_breaker', $this->getTieBreaker(), self::TIE_BREAKER);

        return ['dis_max' => $innerQuery];
    }

    public function addQueries(AbstractQuery ...$queries): void
    {
        array_push($this->queries, ...$queries);
    }

    /**
     * @return AbstractQuery[]
     */
    public function getQueries(): array
    {
        return $this->queries;
    }

    public function getTieBreaker(): float
    {
        return $this->tieBreaker;
    }

    public function setTieBreaker(float $tieBreaker): void
    {
        $this->tieBreaker = $tieBreaker;
    }
}
