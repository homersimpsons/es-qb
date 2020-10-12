<?php

declare(strict_types=1);

namespace EsQb\Query;

use EsQb\Utils;

final class FuzzyQuery extends AbstractQuery implements MultiTermQuery
{
    private string $field;
    private string $query;
    private ?string $fuzziness    = null;
    private ?int $maxExpansions   = null;
    private ?int $prefixLength    = null;
    private ?bool $transpositions = null;
    private ?string $rewrite      = null;

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
        $innerQuery =  ['value' => $this->query];
        $this->printBoostAndQueryName($innerQuery);
        Utils::printIfNotDefault($innerQuery, 'fuzziness', $this->getFuzziness(), null);
        Utils::printIfNotDefault($innerQuery, 'max_expansions', $this->getMaxExpansions(), null);
        Utils::printIfNotDefault($innerQuery, 'prefix_length', $this->getPrefixLength(), null);
        Utils::printIfNotDefault($innerQuery, 'transpositions', $this->getTranspositions(), null);
        Utils::printIfNotDefault($innerQuery, 'rewrite', $this->getRewrite(), null);

        return ['fuzzy' => [$this->field => $innerQuery]];
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getQuery(): string
    {
        return $this->query;
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

    public function getTranspositions(): ?bool
    {
        return $this->transpositions;
    }

    public function setTranspositions(?bool $transpositions): void
    {
        $this->transpositions = $transpositions;
    }

    public function getRewrite(): ?string
    {
        return $this->rewrite;
    }

    public function setRewrite(?string $rewrite): void
    {
        $this->rewrite = $rewrite;
    }
}
