<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\Query\WildcardQuery;
use PHPUnit\Framework\TestCase;

class WildcardQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'wildcard' => [
            'field' => [
                'boost' => 2.0,
                '_name' => 'queryName',
                'value' => 'query',
                'rewrite' => 'constant_score',
            ],
        ],
    ];

    public function testBase(): void
    {
        $this->assertEquals(
            ['wildcard' => ['field' => ['value' => 'query']]],
            (new WildcardQuery('field', 'query'))->toQuery()
        );
    }

    public function testWithAll(): void
    {
        $query = new WildcardQuery('field', 'query');
        $query->setQueryName('queryName');
        $query->setBoost(2.0);
        $query->setRewrite('constant_score');
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
