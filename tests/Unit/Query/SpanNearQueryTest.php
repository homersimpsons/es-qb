<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\Query\SpanNearQuery;
use EsQb\Query\SpanTermQuery;
use PHPUnit\Framework\TestCase;

class SpanNearQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'span_near' => [
            'clauses' => [
                ['span_term' => ['field' => ['value' => 'query']]],
                ['span_term' => ['field' => ['value' => 'query']]],
                ['span_term' => ['field' => ['value' => 'query']]],
            ],
            'slop' => 12,
            '_name' => 'queryName',
            'boost' => 2.0,
            'in_order' => true,
        ],
    ];

    public function testBase(): void
    {
        $this->assertEquals(
            ['span_near' => ['clauses' => [['span_term' => ['field' => ['value' => 'query']]]], 'slop' => 12]],
            (new SpanNearQuery(new SpanTermQuery('field', 'query'), 12))->toQuery()
        );
    }

    public function testWithAll(): void
    {
        $query = new SpanNearQuery(new SpanTermQuery('field', 'query'), 12);
        $query->setQueryName('queryName');
        $query->setBoost(2.0);
        $query->addClauses(new SpanTermQuery('field', 'query'), new SpanTermQuery('field', 'query'));
        $query->setInOrder(true);
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
