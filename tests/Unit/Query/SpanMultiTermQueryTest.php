<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\Query\PrefixQuery;
use EsQb\Query\SpanMultiTermQuery;
use PHPUnit\Framework\TestCase;

class SpanMultiTermQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'span_multi' => [
            'match' => ['prefix' => ['field' => ['value' => 'query']]],
            '_name' => 'queryName',
            'boost' => 2.0,
        ],
    ];

    public function testBase(): void
    {
        $this->assertEquals(
            ['span_multi' => ['match' => ['prefix' => ['field' => ['value' => 'query']]]]],
            (new SpanMultiTermQuery(new PrefixQuery('field', 'query')))->toQuery()
        );
    }

    public function testWithAll(): void
    {
        $query = new SpanMultiTermQuery(new PrefixQuery('field', 'query'));
        $query->setQueryName('queryName');
        $query->setBoost(2.0);
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
