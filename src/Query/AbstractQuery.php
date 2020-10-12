<?php

declare(strict_types=1);

namespace EsQb\Query;

use EsQb\Utils;
use InvalidArgumentException;

// phpcs:ignore SlevomatCodingStandard.Classes.SuperfluousAbstractClassNaming.SuperfluousPrefix
abstract class AbstractQuery
{
    public const DEFAULT_BOOST   = 1.;
    protected ?string $queryName = null;
    private float $boost         = self::DEFAULT_BOOST;

    public function getQueryName(): ?string
    {
        return $this->queryName;
    }

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/7.8/search-request-body.html#request-body-search-queries-and-filters
     */
    public function setQueryName(?string $queryName): void
    {
        $this->queryName = $queryName;
    }

    public function getBoost(): float
    {
        return $this->boost;
    }

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/mapping-boost.html
     */
    public function setBoost(float $boost): void
    {
        if ($boost < 0) {
            throw new InvalidArgumentException('negative [boost] not allowed use a value between 0 and 1 to deboost');
        }

        $this->boost = $boost;
    }

    /**
     * @return array<string, mixed>
     */
    final public function toQuery(): array
    {
        return $this->doToQuery();
    }

    /**
     * @param array<string, mixed> $query
     */
    protected function printBoostAndQueryName(array &$query): void
    {
        Utils::printIfNotDefault($query, 'boost', $this->getBoost(), self::DEFAULT_BOOST);
        Utils::printIfNotDefault($query, '_name', $this->getQueryName(), null);
    }

    /**
     * @return array<string, mixed>
     */
    abstract protected function doToQuery(): array;
}
