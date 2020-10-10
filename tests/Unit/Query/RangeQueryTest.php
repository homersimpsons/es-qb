<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\Query\RangeQuery;
use PHPUnit\Framework\TestCase;

class RangeQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'range' => [
            'field' => [
                'boost' => 2.0,
                '_name' => 'queryName',
                'gt' => '10',
                'gte' => '11',
                'lt' => '20',
                'lte' => '19',
                'format' => 'epoch_second',
                'relation' => 'CONTAINS',
                'time_zone' => '+01:00',
            ],
        ],
    ];

    public function testBase(): void
    {
        $query = new RangeQuery('field');
        $query->setGt('10');
        $this->assertEquals(
            ['range' => ['field' => ['gt' => '10']]],
            $query->toQuery()
        );
    }

    public function testWithAll(): void
    {
        $query = new RangeQuery('field');
        $query->setQueryName('queryName');
        $query->setBoost(2.0);
        $query->setGt('10');
        $query->setGte('11');
        $query->setLt('20');
        $query->setLte('19');
        $query->setFormat('epoch_second');
        $query->setRelation('CONTAINS');
        $query->setTimeZone('+01:00');
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
