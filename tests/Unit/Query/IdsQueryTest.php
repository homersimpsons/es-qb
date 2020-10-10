<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\Query\IdsQuery;
use PHPUnit\Framework\TestCase;

class IdsQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'ids' => [
            'boost' => 2.0,
            '_name' => 'test',
            'values' => ['1', '4', '100'],
        ],
    ];

    public function testBase(): void
    {
        $query = new IdsQuery();
        $query->addIds('1');
        $this->assertEquals(['ids' => ['values' => ['1']]], $query->toQuery());
    }

    public function testFullQuery(): void
    {
        $query = new IdsQuery();
        $query->setBoost(2.0);
        $query->setQueryName('test');
        $query->addIds('1', '4');
        $query->addIds('100');
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
