<?php

declare(strict_types=1);

namespace EsQb\Query;

use EsQb\Utils;
use InvalidArgumentException;

final class MatchQuery extends AbstractQuery
{
    private string $field;
    private string $query;
    private ?string $analyzer                      = null;
    private ?bool $autoGenerateSynonymsPhraseQuery = null;
    private ?string $fuzziness                     = null;
    private ?int $maxExpansions                    = null;
    private ?int $prefixLength                     = null;
    private ?bool $fuzzyTranspositions             = null;
    private ?string $fuzzyRewrite                  = null;
    private ?bool $lenient                         = null;
    private ?string $operator                      = null;
    private ?string $minimumShouldMatch            = null;
    private ?string $zeroTermsQuery                = null;

    /**
     * @param string $field The field name.
     * @param string $query The query text (to be analyzed).
     */
    public function __construct(string $field, string $query)
    {
        $this->field = $field;
        $this->query = $query;
    }

    /**
     * @inheritDoc
     */
    protected function doToQuery(): array
    {
        $innerQuery =  ['query' => $this->query];
        $this->printBoostAndQueryName($innerQuery);
        Utils::printIfNotDefault($innerQuery, 'analyzer', $this->getAnalyzer(), null);
        Utils::printIfNotDefault(
            $innerQuery,
            'auto_generate_synonyms_phrase_query',
            $this->getAutoGenerateSynonymsPhraseQuery(),
            null
        );
        Utils::printIfNotDefault($innerQuery, 'fuzziness', $this->getFuzziness(), null);
        Utils::printIfNotDefault($innerQuery, 'max_expansions', $this->getMaxExpansions(), null);
        Utils::printIfNotDefault($innerQuery, 'prefix_length', $this->getPrefixLength(), null);
        Utils::printIfNotDefault($innerQuery, 'fuzzy_transpositions', $this->getFuzzyTranspositions(), null);
        Utils::printIfNotDefault($innerQuery, 'fuzzy_rewrite', $this->getFuzzyRewrite(), null);
        Utils::printIfNotDefault($innerQuery, 'lenient', $this->getLenient(), null);
        Utils::printIfNotDefault($innerQuery, 'operator', $this->getOperator(), null);
        Utils::printIfNotDefault($innerQuery, 'minimum_should_match', $this->getMinimumShouldMatch(), null);
        Utils::printIfNotDefault($innerQuery, 'zero_terms_query', $this->getZeroTermsQuery(), null);

        return ['match' => [$this->field => $innerQuery]];
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

    public function getAutoGenerateSynonymsPhraseQuery(): ?bool
    {
        return $this->autoGenerateSynonymsPhraseQuery;
    }

    public function setAutoGenerateSynonymsPhraseQuery(?bool $autoGenerateSynonymsPhraseQuery): void
    {
        $this->autoGenerateSynonymsPhraseQuery = $autoGenerateSynonymsPhraseQuery;
    }

    public function getFuzziness(): ?string
    {
        return $this->fuzziness;
    }

    public function setFuzziness(?string $fuzziness): void
    {
        $this->fuzziness = $fuzziness;
    }

    public function getMaxExpansions(): ?int
    {
        return $this->maxExpansions;
    }

    public function setMaxExpansions(?int $maxExpansions): void
    {
        $this->maxExpansions = $maxExpansions;
    }

    public function getPrefixLength(): ?int
    {
        return $this->prefixLength;
    }

    public function setPrefixLength(?int $prefixLength): void
    {
        $this->prefixLength = $prefixLength;
    }

    public function getFuzzyTranspositions(): ?bool
    {
        return $this->fuzzyTranspositions;
    }

    public function setFuzzyTranspositions(?bool $fuzzyTranspositions): void
    {
        $this->fuzzyTranspositions = $fuzzyTranspositions;
    }

    public function getFuzzyRewrite(): ?string
    {
        return $this->fuzzyRewrite;
    }

    public function setFuzzyRewrite(?string $fuzzyRewrite): void
    {
        $this->fuzzyRewrite = $fuzzyRewrite;
    }

    public function getLenient(): ?bool
    {
        return $this->lenient;
    }

    public function setLenient(?bool $lenient): void
    {
        $this->lenient = $lenient;
    }

    public function getOperator(): ?string
    {
        return $this->operator;
    }

    public function setOperator(?string $operator): void
    {
        if ($operator !== 'AND' && $operator !== 'OR') {
            throw new InvalidArgumentException('$operator should be one of `AND` or `OR`.');
        }

        $this->operator = $operator;
    }

    public function getMinimumShouldMatch(): ?string
    {
        return $this->minimumShouldMatch;
    }

    public function setMinimumShouldMatch(?string $minimumShouldMatch): void
    {
        $this->minimumShouldMatch = $minimumShouldMatch;
    }

    public function getZeroTermsQuery(): ?string
    {
        return $this->zeroTermsQuery;
    }

    public function setZeroTermsQuery(?string $zeroTermsQuery): void
    {
        $this->zeroTermsQuery = $zeroTermsQuery;
    }
}
