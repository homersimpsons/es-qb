<?php

declare(strict_types=1);

namespace EsQb\Query;

interface SpanQuery
{
    /**
     * @return array<string, mixed>
     */
    public function toQuery(): array;
}
