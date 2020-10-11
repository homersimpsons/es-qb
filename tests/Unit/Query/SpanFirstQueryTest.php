<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\Query\SpanFirstQuery;
use EsQb\Query\SpanTermQuery;
use PHPUnit\Framework\TestCase;

class SpanFirstQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'span_first' => [
            'match' => [
                'span_term' => ['field' => ['value' => 'query']],
            ],
            'end' => 3,
            '_name' => 'queryName',
            'boost' => 2.0,
        ],
    ];

    public function testBase(): void
    {
        $this->assertEquals(
            ['span_first' => ['match' => ['span_term' => ['field' => ['value' => 'query']]], 'end' => 3]],
            (new SpanFirstQuery(new SpanTermQuery('field', 'query'), 3))->toQuery()
        );
    }

    public function testWithAll(): void
    {
        $query = new SpanFirstQuery(new SpanTermQuery('field', 'query'), 3);
        $query->setQueryName('queryName');
        $query->setBoost(2.0);
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
