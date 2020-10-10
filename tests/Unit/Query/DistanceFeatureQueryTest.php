<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\Query\DistanceFeatureQuery;
use PHPUnit\Framework\TestCase;

class DistanceFeatureQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'distance_feature' => [
            'boost' => 2.0,
            '_name' => 'test',
            'field' => 'date',
            'pivot' => '7d',
            'origin' => 'now',
        ],
    ];

    public function testBase(): void
    {
        $this->assertEquals(
            ['distance_feature' => ['field' => 'date', 'pivot' => '7d', 'origin' => 'now']],
            (new DistanceFeatureQuery('date', 'now', '7d'))->toQuery()
        );
    }

    public function testFullQuery(): void
    {
        $query = new DistanceFeatureQuery('date', 'now', '7d');
        $query->setBoost(2.0);
        $query->setQueryName('test');
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
