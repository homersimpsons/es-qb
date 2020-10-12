<?php

declare(strict_types=1);

namespace EsQb\Query;

use function assert;
use function is_bool;
use function is_float;
use function is_int;
use function is_string;

class TermQuery extends AbstractQuery
{
    private string $field;
    /** @var bool|float|int|string */
    private $value;

    /**
     * @param string|int|float|bool $value
     */
    public function __construct(string $field, $value)
    {
        assert(is_string($value) || is_int($value) || is_float($value) || is_bool($value));
        $this->field = $field;
        $this->value = $value;
    }

    /**
     * {@inheritDoc}
     */
    protected function doToQuery(): array
    {
        $innerQuery = ['value' => $this->value];
        $this->printBoostAndQueryName($innerQuery);

        return ['term' => [$this->field => $innerQuery]];
    }
}
