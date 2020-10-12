<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\Query\MatchAllQuery;
use EsQb\Query\NestedQuery;
use EsQb\Query\TermQuery;
use PHPUnit\Framework\TestCase;
use stdClass;

class NestedQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'nested' => [
            'path' => 'field',
            'query' => ['term' => ['field' => ['value' => 'query']]],
            'boost' => 2.0,
            '_name' => 'test',
            'score_mode' => 'max',
            'ignore_unmapped' => true,
        ],
    ];

    public function testBase(): void
    {
        $this->assertEquals(
            ['nested' => ['path' => 'field', 'query' => ['match_all' => new stdClass()]]],
            (new NestedQuery('field', new MatchAllQuery()))->toQuery()
        );
    }

    public function testFullQuery(): void
    {
        $query = new NestedQuery('field', new TermQuery('field', 'query'));
        $query->setBoost(2.0);
        $query->setQueryName('test');
        $query->setScoreMode('max');
        $query->setIgnoreUnmapped(true);
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
