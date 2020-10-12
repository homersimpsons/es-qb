<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\Query\MatchAllQuery;
use EsQb\Query\ScriptScoreQuery;
use EsQb\Query\TermQuery;
use EsQb\Script;
use PHPUnit\Framework\TestCase;
use stdClass;

class ScriptScoreQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'script_score' => [
            'query' => ['term' => ['field' => ['value' => 'query']]],
            'script' => ['lang' => 'expression', 'source' => 'multiplier', 'params' => ['multiplier' => 2]],
            'boost' => 2.0,
            '_name' => 'test',
        ],
    ];

    public function testBase(): void
    {
        $this->assertEquals(
            ['script_score' => ['query' => ['match_all' => new stdClass()], 'script' => []]],
            (new ScriptScoreQuery(new MatchAllQuery(), new Script()))->toQuery()
        );
    }

    public function testFullQuery(): void
    {
        $script = new Script();
        $script->setLang('expression');
        $script->setSource('multiplier');
        $script->setParams(['multiplier' => 2]);
        $query = new ScriptScoreQuery(new TermQuery('field', 'query'), $script);
        $query->setBoost(2.0);
        $query->setQueryName('test');
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
