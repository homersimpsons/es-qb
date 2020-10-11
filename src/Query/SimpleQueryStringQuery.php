<?php

declare(strict_types=1);

namespace EsQb\Query;

use function array_push;

final class SimpleQueryStringQuery extends AbstractQuery
{
    public const DEFAULT_OPERATOR = 'OR';

    private string $query;
    /** @var string[] */
    private array $fields                          = [];
    private string $defaultOperator                = self::DEFAULT_OPERATOR;
    private ?bool $analyzeWildcard                 = null;
    private ?string $analyzer                      = null;
    private ?bool $autoGenerateSynonymsPhraseQuery = null;
    private ?string $flags                         = null;
    private ?int $fuzzyMaxExpansions               = null;
    private ?int $fuzzyPrefixLength                = null;
    private ?bool $fuzzyTranspositions             = null;
    private ?bool $lenient                         = null;
    private ?string $minimumShouldMatch            = null;
    private ?string $quoteFieldSuffix              = null;

    public function __construct(string $query)
    {
        $this->query = $query;
    }

    /**
     * @inheritDoc
     */
    protected function doToQuery(): array
    {
        $innerQuery =  ['query' => $this->query];
        $this->printBoostAndQueryName($innerQuery);
        $this->printIfNotDefault($innerQuery, 'fields', $this->getFields(), []);
        $this->printIfNotDefault($innerQuery, 'default_operator', $this->getDefaultOperator(), self::DEFAULT_OPERATOR);
        $this->printIfNotDefault($innerQuery, 'analyze_wildcard', $this->getAnalyzeWildcard(), null);
        $this->printIfNotDefault($innerQuery, 'analyzer', $this->getAnalyzer(), null);
        $this->printIfNotDefault(
            $innerQuery,
            'auto_generate_synonyms_phrase_query',
            $this->getAutoGenerateSynonymsPhraseQuery(),
            null
        );
        $this->printIfNotDefault($innerQuery, 'flags', $this->getFlags(), null);
        $this->printIfNotDefault($innerQuery, 'fuzzy_max_expansions', $this->getFuzzyMaxExpansions(), null);
        $this->printIfNotDefault($innerQuery, 'fuzzy_prefix_length', $this->getFuzzyPrefixLength(), null);
        $this->printIfNotDefault($innerQuery, 'fuzzy_transpositions', $this->getFuzzyTranspositions(), null);
        $this->printIfNotDefault($innerQuery, 'lenient', $this->getLenient(), null);
        $this->printIfNotDefault($innerQuery, 'minimum_should_match', $this->getMinimumShouldMatch(), null);
        $this->printIfNotDefault($innerQuery, 'quote_field_suffix', $this->getQuoteFieldSuffix(), null);

        return ['simple_query_string' => $innerQuery];
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * @return string[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    public function addFields(string ...$fields): void
    {
        array_push($this->fields, ...$fields);
    }

    public function getDefaultOperator(): string
    {
        return $this->defaultOperator;
    }

    public function setDefaultOperator(string $defaultOperator): void
    {
        $this->defaultOperator = $defaultOperator;
    }

    public function getAnalyzeWildcard(): ?bool
    {
        return $this->analyzeWildcard;
    }

    public function setAnalyzeWildcard(?bool $analyzeWildcard): void
    {
        $this->analyzeWildcard = $analyzeWildcard;
    }

    public function getAnalyzer(): ?string
    {
        return $this->analyzer;
    }

    public function setAnalyzer(?string $analyzer): void
    {
        $this->analyzer = $analyzer;
    }

    public function getAutoGenerateSynonymsPhraseQuery(): ?bool
    {
        return $this->autoGenerateSynonymsPhraseQuery;
    }

    public function setAutoGenerateSynonymsPhraseQuery(?bool $autoGenerateSynonymsPhraseQuery): void
    {
        $this->autoGenerateSynonymsPhraseQuery = $autoGenerateSynonymsPhraseQuery;
    }

    public function getFlags(): ?string
    {
        return $this->flags;
    }

    public function setFlags(?string $flags): void
    {
        $this->flags = $flags;
    }

    public function getFuzzyMaxExpansions(): ?int
    {
        return $this->fuzzyMaxExpansions;
    }

    public function setFuzzyMaxExpansions(?int $fuzzyMaxExpansions): void
    {
        $this->fuzzyMaxExpansions = $fuzzyMaxExpansions;
    }

    public function getFuzzyPrefixLength(): ?int
    {
        return $this->fuzzyPrefixLength;
    }

    public function setFuzzyPrefixLength(?int $fuzzyPrefixLength): void
    {
        $this->fuzzyPrefixLength = $fuzzyPrefixLength;
    }

    public function getFuzzyTranspositions(): ?bool
    {
        return $this->fuzzyTranspositions;
    }

    public function setFuzzyTranspositions(?bool $fuzzyTranspositions): void
    {
        $this->fuzzyTranspositions = $fuzzyTranspositions;
    }

    public function getLenient(): ?bool
    {
        return $this->lenient;
    }

    public function setLenient(?bool $lenient): void
    {
        $this->lenient = $lenient;
    }

    public function getMinimumShouldMatch(): ?string
    {
        return $this->minimumShouldMatch;
    }

    public function setMinimumShouldMatch(?string $minimumShouldMatch): void
    {
        $this->minimumShouldMatch = $minimumShouldMatch;
    }

    public function getQuoteFieldSuffix(): ?string
    {
        return $this->quoteFieldSuffix;
    }

    public function setQuoteFieldSuffix(?string $quoteFieldSuffix): void
    {
        $this->quoteFieldSuffix = $quoteFieldSuffix;
    }
}
