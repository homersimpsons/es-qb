<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\Query\SpanNotQuery;
use EsQb\Query\SpanTermQuery;
use PHPUnit\Framework\TestCase;

class SpanNotQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'span_not' => [
            'include' => ['span_term' => ['field' => ['value' => 'query']]],
            'exclude' => ['span_term' => ['field' => ['value' => 'query']]],
            '_name' => 'queryName',
            'boost' => 2.0,
            'pre' => 3,
            'post' => 3,
            'dist' => 3,
        ],
    ];

    public function testBase(): void
    {
        $this->assertEquals(
            [
                'span_not' => [
                    'include' => ['span_term' => ['field' => ['value' => 'query']]],
                    'exclude' => ['span_term' => ['field' => ['value' => 'query']]],
                ],
            ],
            (new SpanNotQuery(new SpanTermQuery('field', 'query'), new SpanTermQuery('field', 'query')))->toQuery()
        );
    }

    public function testWithAll(): void
    {
        $query = new SpanNotQuery(new SpanTermQuery('field', 'query'), new SpanTermQuery('field', 'query'));
        $query->setQueryName('queryName');
        $query->setBoost(2.0);
        $query->setPre(3);
        $query->setPost(3);
        $query->setDist(3);
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
