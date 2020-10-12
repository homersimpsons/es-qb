<?php

declare(strict_types=1);

namespace EsQb\Query;

use EsQb\Utils;

class MatchPhraseQuery extends AbstractQuery
{
    private string $field;
    private string $query;
    private ?string $analyzer = null;

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

        return ['match_phrase' => [$this->field => $innerQuery]];
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
}
