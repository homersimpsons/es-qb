<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\Query\ExistsQuery;
use PHPUnit\Framework\TestCase;

class ExistsQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'exists' => [
            'field' => 'field',
            'boost' => 2.0,
            '_name' => 'queryName',
        ],
    ];

    public function testBase(): void
    {
        $this->assertEquals(['exists' => ['field' => 'field']], (new ExistsQuery('field'))->toQuery());
    }

    public function testWithAll(): void
    {
        $query = new ExistsQuery('field');
        $query->setQueryName('queryName');
        $query->setBoost(2.0);
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
