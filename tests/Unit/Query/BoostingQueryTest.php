<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\Query\BoostingQuery;
use EsQb\Query\MatchAllQuery;
use EsQb\Query\TermQuery;
use PHPUnit\Framework\TestCase;
use stdClass;

class BoostingQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'boosting' => [
            'positive' => ['term' => ['field' => ['value' => 'query']]],
            'negative' => ['term' => ['field' => ['value' => 'query']]],
            'negative_boost' => 0.5,
            'boost' => 2.0,
            '_name' => 'test',
        ],
    ];

    public function testBase(): void
    {
        $this->assertEquals(
            [
                'boosting' => [
                    'positive' => ['match_all' => new stdClass()],
                    'negative' => ['match_all' => new stdClass()],
                    'negative_boost' => 0.5,
                ],
            ],
            (new BoostingQuery(new MatchAllQuery(), new MatchAllQuery(), 0.5))->toQuery()
        );
    }

    public function testFullQuery(): void
    {
        $query = new BoostingQuery(
            new TermQuery('field', 'query'),
            new TermQuery('field', 'query'),
            0.5
        );
        $query->setBoost(2.0);
        $query->setQueryName('test');
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
