<?php

declare(strict_types=1);

namespace EsQb\Query;

class TermsQuery extends AbstractQuery
{
    private string $field;
    /** @var array<bool|float|int|string> */
    private array $values;

    /**
     * @param array<string|int|float|bool> $values
     */
    public function __construct(string $field, array $values)
    {
        $this->field  = $field;
        $this->values = $values;
    }

    /**
     * {@inheritDoc}
     */
    protected function doToQuery(): array
    {
        $innerQuery = [$this->field => $this->values];
        $this->printBoostAndQueryName($innerQuery);

        return ['terms' => $innerQuery];
    }
}
