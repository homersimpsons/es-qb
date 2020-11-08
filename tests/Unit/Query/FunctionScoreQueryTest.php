<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\Query\FunctionScore\RandomScoreFunction;
use EsQb\Query\FunctionScoreQuery;
use EsQb\Query\MatchAllQuery;
use EsQb\Query\TermQuery;
use PHPUnit\Framework\TestCase;
use stdClass;

class FunctionScoreQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'function_score' => [
            'query' => ['term' => ['field' => ['value' => 'query']]],
            'functions' => [
                [
                    'random_score' => ['seed' => 1],
                    'weight' => 0.5,
                    'filter' => ['term' => ['field' => ['value' => 'query']]],
                ],
                [
                    'random_score' => ['seed' => 1],
                    'weight' => 0.75,
                    'filter' => ['term' => ['field' => ['value' => 'query1']]],
                ],
            ],
            'score_mode' => 'avg',
            'boost_mode' => 'avg',
            'max_boost' => 42.0,
            'min_score' => 1.0,
            'boost' => 2.0,
            '_name' => 'test',
        ],
    ];

    public function testBase(): void
    {
        $this->assertEquals(
            [
                'function_score' => [
                    'query' => ['match_all' => new stdClass()],
                    'functions' => [['random_score' => new stdClass()]],
                ],
            ],
            (new FunctionScoreQuery(new MatchAllQuery(), new RandomScoreFunction()))->toQuery()
        );
    }

    public function testFullQuery(): void
    {
        $randomScore = new RandomScoreFunction();
        $randomScore->setSeed(1);
        $query = new FunctionScoreQuery(
            new TermQuery('field', 'query'),
            $randomScore,
            0.5,
            new TermQuery('field', 'query'),
        );
        $query->setScoreMode('avg');
        $query->setBoostMode('avg');
        $query->setMaxBoost(42.);
        $query->setMinScore(1.);
        $query->addFunction($randomScore, 0.75, new TermQuery('field', 'query1'));
        $query->setBoost(2.0);
        $query->setQueryName('test');
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
