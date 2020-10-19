<?php

declare(strict_types=1);

namespace EsQb\Query;

final class ExistsQuery extends AbstractQuery
{
    public const RELATION = 'INTERSECTS';

    private string $field;

    public function __construct(string $field)
    {
        $this->field = $field;
    }

    /**
     * {@inheritDoc}
     */
    protected function doToQuery(): array
    {
        $innerQuery = ['field' => $this->field];
        $this->printBoostAndQueryName($innerQuery);

        return ['exists' => $innerQuery];
    }
}
