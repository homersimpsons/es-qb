<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\Query\MatchAllQuery;
use PHPUnit\Framework\TestCase;

class MatchAllQueryTest extends TestCase
{
    public const FULL_QUERY = ['match_all' => ['boost' => 2.0, '_name' => 'test']];

    public function testBase(): void
    {
        $this->assertEquals(['match_all' => []], (new MatchAllQuery())->toQuery());
    }

    public function testWithBoost(): void
    {
        $query = new MatchAllQuery();
        $this->assertEquals(['match_all' => []], $query->toQuery());
        $query->setBoost(2.0);
        $this->assertEquals(['match_all' => ['boost' => 2.0]], $query->toQuery());
    }

    public function testWithName(): void
    {
        $query = new MatchAllQuery();
        $this->assertEquals(['match_all' => []], $query->toQuery());
        $query->setQueryName('test');
        $this->assertEquals(['match_all' => ['_name' => 'test']], $query->toQuery());
    }

    public function testFullQuery(): void
    {
        $query = new MatchAllQuery();
        $query->setBoost(2.0);
        $query->setQueryName('test');
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
