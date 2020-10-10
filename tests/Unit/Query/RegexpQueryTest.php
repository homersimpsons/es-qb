<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\Query\RegexpQuery;
use PHPUnit\Framework\TestCase;

class RegexpQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'regexp' => [
            'field' => [
                'value' => 'query',
                '_name' => 'queryName',
                'boost' => 2.0,
                'flags' => 'ALL',
                'max_determinized_states' => 1000,
                'rewrite' => 'constant_score',
            ],
        ],
    ];

    public function testBase(): void
    {
        $this->assertEquals(
            ['regexp' => ['field' => ['value' => 'query']]],
            (new RegexpQuery('field', 'query'))->toQuery()
        );
    }

    public function testWithAll(): void
    {
        $query = new RegexpQuery('field', 'query');
        $query->setQueryName('queryName');
        $query->setBoost(2.0);
        $query->setFlags('ALL');
        $query->setMaxDeterminizedStates(1000);
        $query->setRewrite('constant_score');
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
