<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\Query\ScriptQuery;
use EsQb\Script;
use PHPUnit\Framework\TestCase;

class ScriptQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'script' => [
            'script' => ['lang' => 'expression', 'source' => 'multiplier', 'params' => ['multiplier' => 2]],
            'boost' => 2.0,
            '_name' => 'test',
        ],
    ];

    public function testBase(): void
    {
        $this->assertEquals(
            ['script' => ['script' => []]],
            (new ScriptQuery(new Script()))->toQuery()
        );
    }

    public function testFullQuery(): void
    {
        $script = new Script();
        $script->setLang('expression');
        $script->setSource('multiplier');
        $script->setParams(['multiplier' => 2]);
        $query = new ScriptQuery($script);
        $query->setBoost(2.0);
        $query->setQueryName('test');
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
