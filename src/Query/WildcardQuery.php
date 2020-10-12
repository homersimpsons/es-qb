<?php

declare(strict_types=1);

namespace EsQb\Query;

use EsQb\Utils;

class WildcardQuery extends AbstractQuery implements MultiTermQuery
{
    private string $field;
    private string $query;
    private ?string $rewrite = null;

    public function __construct(string $field, string $query)
    {
        $this->field = $field;
        $this->query = $query;
    }

    /**
     * {@inheritDoc}
     */
    protected function doToQuery(): array
    {
        $innerQuery = ['value' => $this->query];
        $this->printBoostAndQueryName($innerQuery);
        Utils::printIfNotDefault($innerQuery, 'rewrite', $this->getRewrite(), null);

        return ['wildcard' => [$this->field => $innerQuery]];
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
