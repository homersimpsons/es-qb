<?php

declare(strict_types=1);

namespace EsQb\Integration;

use EsQb\Query\AbstractQuery;

class ArrayQueryWrapper extends AbstractQuery
{
    /** @var array<string, mixed> */
    private array $query;

    /**
     * @param array<string, mixed> $query
     */
    public function __construct(array $query)
    {
        $this->query = $query;
    }

    /**
     * @inheritDoc
     */
    protected function doToQuery(): array
    {
        return $this->query;
    }
}
