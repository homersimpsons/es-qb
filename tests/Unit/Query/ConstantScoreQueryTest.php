<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\Query\ConstantScoreQuery;
use EsQb\Query\MatchAllQuery;
use EsQb\Query\TermQuery;
use PHPUnit\Framework\TestCase;
use stdClass;

class ConstantScoreQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'constant_score' => [
            'filter' => ['term' => ['field' => ['value' => 'query']]],
            'boost' => 2.0,
            '_name' => 'test',
        ],
    ];

    public function testBase(): void
    {
        $this->assertEquals(
            ['constant_score' => ['filter' => ['match_all' => new stdClass()]]],
            (new ConstantScoreQuery(new MatchAllQuery()))->toQuery()
        );
    }

    public function testFullQuery(): void
    {
        $query = new ConstantScoreQuery(new TermQuery('field', 'query'));
        $query->setBoost(2.0);
        $query->setQueryName('test');
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
