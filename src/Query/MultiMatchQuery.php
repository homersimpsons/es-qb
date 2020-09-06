<?php

declare(strict_types=1);

namespace EsQb\Query;

use InvalidArgumentException;

use function assert;

final class MultiMatchQuery extends AbstractQuery
{
    /** @var string[] */
    private array $fields;
    private string $query;
    private ?string $type                          = null;
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
    private float $tieBreaker                      = 0.;

    /**
     * @param string[] $fields The field names.
     * @param string   $query  The query text (to be analyzed).
     */
    public function __construct(string $query, string ...$fields)
    {
        assert(! empty($fields));
        $this->fields = $fields;
        $this->query  = $query;
    }

    /**
     * @inheritDoc
     */
    protected function doToQuery(): array
    {
        $innerQuery = [
            'query' => $this->query,
            'fields' => $this->fields,
        ];
        $this->printBoostAndQueryName($innerQuery);
        $this->printIfNotDefault($innerQuery, 'type', $this->getType(), null);
        $this->printIfNotDefault($innerQuery, 'analyzer', $this->getAnalyzer(), null);
        $this->printIfNotDefault(
            $innerQuery,
            'auto_generate_synonyms_phrase_query',
            $this->getAutoGenerateSynonymsPhraseQuery(),
            null
        );
        $this->printIfNotDefault($innerQuery, 'fuzziness', $this->getFuzziness(), null);
        $this->printIfNotDefault($innerQuery, 'max_expansions', $this->getMaxExpansions(), null);
        $this->printIfNotDefault($innerQuery, 'prefix_length', $this->getPrefixLength(), null);
        $this->printIfNotDefault($innerQuery, 'fuzzy_transpositions', $this->getFuzzyTranspositions(), null);
        $this->printIfNotDefault($innerQuery, 'fuzzy_rewrite', $this->getFuzzyRewrite(), null);
        $this->printIfNotDefault($innerQuery, 'lenient', $this->getLenient(), null);
        $this->printIfNotDefault($innerQuery, 'operator', $this->getOperator(), null);
        $this->printIfNotDefault($innerQuery, 'minimum_should_match', $this->getMinimumShouldMatch(), null);
        $this->printIfNotDefault($innerQuery, 'zero_terms_query', $this->getZeroTermsQuery(), null);
        $this->printIfNotDefault($innerQuery, 'tie_breaker', $this->getTieBreaker(), 0.);

        return ['multi_match' => $innerQuery];
    }

    /**
     * @return string[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
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

    public function getTieBreaker(): float
    {
        return $this->tieBreaker;
    }

    public function setTieBreaker(float $tieBreaker): void
    {
        $this->tieBreaker = $tieBreaker;
    }
}
