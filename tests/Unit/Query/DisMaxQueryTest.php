<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\Query\DisMaxQuery;
use EsQb\Query\MatchAllQuery;
use EsQb\Query\TermQuery;
use PHPUnit\Framework\TestCase;
use stdClass;

class DisMaxQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'dis_max' => [
            'boost' => 2.0,
            '_name' => 'test',
            'queries' => [
                ['term' => ['field' => ['value' => 'query']]],
                ['term' => ['field' => ['value' => 'query']]],
                ['term' => ['field' => ['value' => 'query']]],
            ],
            'tie_breaker' => 0.7,
        ],
    ];

    public function testBase(): void
    {
        $query = new DisMaxQuery();
        $query->addQueries(new MatchAllQuery());
        $this->assertEquals(['dis_max' => ['queries' => [['match_all' => new stdClass()]]]], $query->toQuery());
    }

    public function testFullQuery(): void
    {
        $query = new DisMaxQuery();
        $query->setBoost(2.0);
        $query->setQueryName('test');
        $query->addQueries(new TermQuery('field', 'query'), new TermQuery('field', 'query'));
        $query->addQueries(new TermQuery('field', 'query'));
        $query->setTieBreaker(0.7);
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
