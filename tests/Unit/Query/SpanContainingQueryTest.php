<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\Query\SpanContainingQuery;
use EsQb\Query\SpanTermQuery;
use PHPUnit\Framework\TestCase;

class SpanContainingQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'span_containing' => [
            'big' => ['span_term' => ['field' => ['value' => 'query']]],
            'little' => ['span_term' => ['field' => ['value' => 'query']]],
            '_name' => 'queryName',
            'boost' => 2.0,
        ],
    ];

    public function testBase(): void
    {
        $this->assertEquals(
            [
                'span_containing' => [
                    'big' => ['span_term' => ['field' => ['value' => 'query']]],
                    'little' => ['span_term' => ['field' => ['value' => 'query']]],
                ],
            ],
            (new SpanContainingQuery(new SpanTermQuery('field', 'query'), new SpanTermQuery('field', 'query')))
                ->toQuery()
        );
    }

    public function testWithAll(): void
    {
        $query = new SpanContainingQuery(new SpanTermQuery('field', 'query'), new SpanTermQuery('field', 'query'));
        $query->setQueryName('queryName');
        $query->setBoost(2.0);
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
