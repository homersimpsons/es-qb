<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\Query\PrefixQuery;
use PHPUnit\Framework\TestCase;

class PrefixQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'prefix' => [
            'field' => [
                'value' => 'query',
                '_name' => 'queryName',
                'boost' => 2.0,
                'rewrite' => 'constant_score_boolean',
            ],
        ],
    ];

    public function testBase(): void
    {
        $this->assertEquals(
            ['prefix' => ['field' => ['value' => 'query']]],
            (new PrefixQuery('field', 'query'))->toQuery()
        );
    }

    public function testWithAll(): void
    {
        $query = new PrefixQuery('field', 'query');
        $query->setQueryName('queryName');
        $query->setBoost(2.0);
        $query->setRewrite('constant_score_boolean');
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
