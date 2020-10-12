<?php

declare(strict_types=1);

namespace EsQb\Query;

use EsQb\Utils;
use InvalidArgumentException;

class MatchPhrasePrefixQuery extends AbstractQuery
{
    public const MAX_EXPANSIONS   = 50;
    public const SLOP             = 0;
    public const ZERO_TERMS_QUERY = 'none';

    private string $field;
    private string $query;
    private ?string $analyzer      = null;
    private int $maxExpansions     = self::MAX_EXPANSIONS;
    private int $slop              = self::SLOP;
    private string $zeroTermsQuery = self::ZERO_TERMS_QUERY;

    public function __construct(string $field, string $text)
    {
        $this->field = $field;
        $this->query = $text;
    }

    /**
     * {@inheritDoc}
     */
    protected function doToQuery(): array
    {
        $innerQuery = ['query' => $this->query];
        $this->printBoostAndQueryName($innerQuery);
        Utils::printIfNotDefault($innerQuery, 'analyzer', $this->getAnalyzer(), null);
        Utils::printIfNotDefault($innerQuery, 'max_expansions', $this->getMaxExpansions(), self::MAX_EXPANSIONS);
        Utils::printIfNotDefault($innerQuery, 'slop', $this->getSlop(), self::SLOP);
        Utils::printIfNotDefault($innerQuery, 'zero_terms_query', $this->getZeroTermsQuery(), self::ZERO_TERMS_QUERY);

        return ['match_phrase_prefix' => [$this->field => $innerQuery]];
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function getAnalyzer(): ?string
    {
        return $this->analyzer;
    }

    public function setAnalyzer(?string $analyzer): void
    {
        $this->analyzer = $analyzer;
    }

    public function getMaxExpansions(): int
    {
        return $this->maxExpansions;
    }

    public function setMaxExpansions(int $maxExpansions): void
    {
        $this->maxExpansions = $maxExpansions;
    }

    public function getSlop(): int
    {
        return $this->slop;
    }

    public function setSlop(int $slop): void
    {
        $this->slop = $slop;
    }

    public function getZeroTermsQuery(): string
    {
        return $this->zeroTermsQuery;
    }

    public function setZeroTermsQuery(string $zeroTermsQuery): void
    {
        if ($zeroTermsQuery !== 'none' && $zeroTermsQuery !== 'all') {
            throw new InvalidArgumentException('$zeroTermsQuery should be one of `none` or `all`.');
        }

        $this->zeroTermsQuery = $zeroTermsQuery;
    }
}
