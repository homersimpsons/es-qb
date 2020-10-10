<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\Query\TermQuery;
use PHPUnit\Framework\TestCase;

class TermQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'term' => [
            'field' => [
                'value' => 'query',
                '_name' => 'queryName',
                'boost' => 2.0,
            ],
        ],
    ];

    public function testBase(): void
    {
        $this->assertEquals(
            ['term' => ['field' => ['value' => 'query']]],
            (new TermQuery('field', 'query'))->toQuery()
        );
    }

    public function testWithAll(): void
    {
        $query = new TermQuery('field', 'query');
        $query->setQueryName('queryName');
        $query->setBoost(2.0);
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
