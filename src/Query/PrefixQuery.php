<?php

declare(strict_types=1);

namespace EsQb\Query;

final class PrefixQuery extends AbstractQuery implements MultiTermQuery
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
     * @inheritDoc
     */
    protected function doToQuery(): array
    {
        $innerQuery =  ['value' => $this->query];
        $this->printBoostAndQueryName($innerQuery);
        $this->printIfNotDefault($innerQuery, 'rewrite', $this->getRewrite(), null);

        return ['prefix' => [$this->field => $innerQuery]];
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getQuery(): string
    {
        return $this->query;
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
