<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\Query\SpanOrQuery;
use EsQb\Query\SpanTermQuery;
use PHPUnit\Framework\TestCase;

class SpanOrQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'span_or' => [
            'clauses' => [
                ['span_term' => ['field' => ['value' => 'query']]],
                ['span_term' => ['field' => ['value' => 'query']]],
                ['span_term' => ['field' => ['value' => 'query']]],
            ],
            '_name' => 'queryName',
            'boost' => 2.0,
        ],
    ];

    public function testBase(): void
    {
        $this->assertEquals(
            ['span_or' => ['clauses' => [['span_term' => ['field' => ['value' => 'query']]]]]],
            (new SpanOrQuery(new SpanTermQuery('field', 'query')))->toQuery()
        );
    }

    public function testWithAll(): void
    {
        $query = new SpanOrQuery(new SpanTermQuery('field', 'query'));
        $query->setQueryName('queryName');
        $query->setBoost(2.0);
        $query->addClauses(new SpanTermQuery('field', 'query'), new SpanTermQuery('field', 'query'));
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
