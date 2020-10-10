<?php

declare(strict_types=1);

namespace EsQb\Query;

use function array_push;

final class QueryStringQuery extends AbstractQuery
{
    public const DEFAULT_OPERATOR        = 'OR';
    public const MAX_DETERMINIZED_STATES = 10000;

    private string $query;
    private ?string $defaultField                  = null;
    private ?bool $allowLeadingWildcard            = null;
    private ?bool $analyzeWildcard                 = null;
    private ?string $analyzer                      = null;
    private ?bool $autoGenerateSynonymsPhraseQuery = null;
    private string $defaultOperator                = self::DEFAULT_OPERATOR;
    private ?bool $enablePositionIncrements        = null;
    /** @var string[] */
    private array $fields               = [];
    private ?string $fuzziness          = null;
    private ?int $fuzzyMaxExpansions    = null;
    private ?int $fuzzyPrefixLength     = null;
    private ?bool $fuzzyTranspositions  = null;
    private ?string $rewrite            = null;
    private ?bool $lenient              = null;
    private int $maxDeterminizedStates  = self::MAX_DETERMINIZED_STATES;
    private ?string $minimumShouldMatch = null;
    private ?string $quoteAnalyzer      = null;
    private ?int $phraseSlop            = null;
    private ?string $quoteFieldSuffix   = null;
    private ?string $timeZone           = null;

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
        $this->printIfNotDefault($innerQuery, 'default_field', $this->getDefaultField(), null);
        $this->printIfNotDefault($innerQuery, 'allow_leading_wildcard', $this->getAllowLeadingWildcard(), null);
        $this->printIfNotDefault($innerQuery, 'analyze_wildcard', $this->getAnalyzeWildcard(), null);
        $this->printIfNotDefault($innerQuery, 'analyzer', $this->getAnalyzer(), null);
        $this->printIfNotDefault(
            $innerQuery,
            'auto_generate_synonyms_phrase_query',
            $this->getAutoGenerateSynonymsPhraseQuery(),
            null
        );
        $this->printIfNotDefault($innerQuery, 'default_operator', $this->getDefaultOperator(), self::DEFAULT_OPERATOR);
        $this->printIfNotDefault($innerQuery, 'enable_position_increments', $this->getEnablePositionIncrements(), null);
        $this->printIfNotDefault($innerQuery, 'fields', $this->getFields(), []);
        $this->printIfNotDefault($innerQuery, 'fuzziness', $this->getFuzziness(), null);
        $this->printIfNotDefault($innerQuery, 'fuzzy_max_expansions', $this->getFuzzyMaxExpansions(), null);
        $this->printIfNotDefault($innerQuery, 'fuzzy_prefix_length', $this->getFuzzyPrefixLength(), null);
        $this->printIfNotDefault($innerQuery, 'fuzzy_transpositions', $this->getFuzzyTranspositions(), null);
        $this->printIfNotDefault($innerQuery, 'lenient', $this->getLenient(), null);
        $this->printIfNotDefault(
            $innerQuery,
            'max_determinized_states',
            $this->getMaxDeterminizedStates(),
            self::MAX_DETERMINIZED_STATES
        );
        $this->printIfNotDefault($innerQuery, 'minimum_should_match', $this->getMinimumShouldMatch(), null);
        $this->printIfNotDefault($innerQuery, 'quote_analyzer', $this->getQuoteAnalyzer(), null);
        $this->printIfNotDefault($innerQuery, 'phrase_slop', $this->getPhraseSlop(), null);
        $this->printIfNotDefault($innerQuery, 'quote_field_suffix', $this->getQuoteFieldSuffix(), null);
        $this->printIfNotDefault($innerQuery, 'rewrite', $this->getRewrite(), null);
        $this->printIfNotDefault($innerQuery, 'time_zone', $this->getTimeZone(), null);

        return ['query_string' => $innerQuery];
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function getDefaultField(): ?string
    {
        return $this->defaultField;
    }

    public function setDefaultField(?string $defaultField): void
    {
        $this->defaultField = $defaultField;
    }

    public function getAllowLeadingWildcard(): ?bool
    {
        return $this->allowLeadingWildcard;
    }

    public function setAllowLeadingWildcard(?bool $allowLeadingWildcard): void
    {
        $this->allowLeadingWildcard = $allowLeadingWildcard;
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

    public function getDefaultOperator(): string
    {
        return $this->defaultOperator;
    }

    public function setDefaultOperator(string $defaultOperator): void
    {
        $this->defaultOperator = $defaultOperator;
    }

    public function getEnablePositionIncrements(): ?bool
    {
        return $this->enablePositionIncrements;
    }

    public function setEnablePositionIncrements(?bool $enablePositionIncrements): void
    {
        $this->enablePositionIncrements = $enablePositionIncrements;
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

    public function getFuzziness(): ?string
    {
        return $this->fuzziness;
    }

    public function setFuzziness(?string $fuzziness): void
    {
        $this->fuzziness = $fuzziness;
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

    public function getRewrite(): ?string
    {
        return $this->rewrite;
    }

    public function setRewrite(?string $rewrite): void
    {
        $this->rewrite = $rewrite;
    }

    public function getLenient(): ?bool
    {
        return $this->lenient;
    }

    public function setLenient(?bool $lenient): void
    {
        $this->lenient = $lenient;
    }

    public function getMaxDeterminizedStates(): int
    {
        return $this->maxDeterminizedStates;
    }

    public function setMaxDeterminizedStates(int $maxDeterminizedStates): void
    {
        $this->maxDeterminizedStates = $maxDeterminizedStates;
    }

    public function getMinimumShouldMatch(): ?string
    {
        return $this->minimumShouldMatch;
    }

    public function setMinimumShouldMatch(?string $minimumShouldMatch): void
    {
        $this->minimumShouldMatch = $minimumShouldMatch;
    }

    public function getQuoteAnalyzer(): ?string
    {
        return $this->quoteAnalyzer;
    }

    public function setQuoteAnalyzer(?string $quoteAnalyzer): void
    {
        $this->quoteAnalyzer = $quoteAnalyzer;
    }

    public function getPhraseSlop(): ?int
    {
        return $this->phraseSlop;
    }

    public function setPhraseSlop(?int $phraseSlop): void
    {
        $this->phraseSlop = $phraseSlop;
    }

    public function getQuoteFieldSuffix(): ?string
    {
        return $this->quoteFieldSuffix;
    }

    public function setQuoteFieldSuffix(?string $quoteFieldSuffix): void
    {
        $this->quoteFieldSuffix = $quoteFieldSuffix;
    }

    public function getTimeZone(): ?string
    {
        return $this->timeZone;
    }

    public function setTimeZone(?string $timeZone): void
    {
        $this->timeZone = $timeZone;
    }
}
