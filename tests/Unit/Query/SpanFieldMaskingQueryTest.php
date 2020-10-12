<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\Query\SpanFieldMaskingQuery;
use EsQb\Query\SpanTermQuery;
use PHPUnit\Framework\TestCase;

class SpanFieldMaskingQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'field_masking_span' => [
            'query' => [
                'span_term' => ['field' => ['value' => 'query']],
            ],
            'field' => 'field',
            '_name' => 'queryName',
            'boost' => 2.0,
        ],
    ];

    public function testBase(): void
    {
        $this->assertEquals(
            [
                'field_masking_span' => [
                    'query' => ['span_term' => ['field' => ['value' => 'query']]],
                    'field' => 'field',
                ],
            ],
            (new SpanFieldMaskingQuery(new SpanTermQuery('field', 'query'), 'field'))->toQuery()
        );
    }

    public function testWithAll(): void
    {
        $query = new SpanFieldMaskingQuery(new SpanTermQuery('field', 'query'), 'field');
        $query->setQueryName('queryName');
        $query->setBoost(2.0);
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
