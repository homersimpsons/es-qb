<?php

declare(strict_types=1);

namespace EsQb\Query;

use function array_map;
use function array_push;

final class BoolQuery extends AbstractQuery
{
    /** @var AbstractQuery[] */
    private array $must = [];
    /** @var AbstractQuery[] */
    private array $filter = [];
    /** @var AbstractQuery[] */
    private array $should = [];
    /** @var AbstractQuery[] */
    private array $mustNot              = [];
    private ?string $minimumShouldMatch = null;

    /**
     * @inheritDoc
     */
    protected function doToQuery(): array
    {
        $innerQuery = [];
        $this->printBoostAndQueryName($innerQuery);
        $this->printIfNotDefault(
            $innerQuery,
            'must',
            array_map(static fn (AbstractQuery $query) => $query->doToQuery(), $this->must),
            []
        );
        $this->printIfNotDefault(
            $innerQuery,
            'filter',
            array_map(static fn (AbstractQuery $query) => $query->doToQuery(), $this->filter),
            []
        );
        $this->printIfNotDefault(
            $innerQuery,
            'should',
            array_map(static fn (AbstractQuery $query) => $query->doToQuery(), $this->should),
            []
        );
        $this->printIfNotDefault(
            $innerQuery,
            'must_not',
            array_map(static fn (AbstractQuery $query) => $query->doToQuery(), $this->mustNot),
            []
        );
        $this->printIfNotDefault($innerQuery, 'minimum_should_match', $this->getMinimumShouldMatch(), null);

        return ['bool' => $innerQuery];
    }

    public function addMust(AbstractQuery ...$queries): void
    {
        array_push($this->must, ...$queries);
    }

    /**
     * @return AbstractQuery[]
     */
    public function getMust(): array
    {
        return $this->must;
    }

    public function addFilter(AbstractQuery ...$queries): void
    {
        array_push($this->filter, ...$queries);
    }

    /**
     * @return AbstractQuery[]
     */
    public function getFilter(): array
    {
        return $this->filter;
    }

    public function addShould(AbstractQuery ...$queries): void
    {
        array_push($this->should, ...$queries);
    }

    /**
     * @return AbstractQuery[]
     */
    public function getShould(): array
    {
        return $this->should;
    }

    public function addMustNot(AbstractQuery ...$queries): void
    {
        array_push($this->mustNot, ...$queries);
    }

    /**
     * @return AbstractQuery[]
     */
    public function getMustNot(): array
    {
        return $this->mustNot;
    }

    public function getMinimumShouldMatch(): ?string
    {
        return $this->minimumShouldMatch;
    }

    public function setMinimumShouldMatch(?string $minimumShouldMatch): void
    {
        $this->minimumShouldMatch = $minimumShouldMatch;
    }
}
