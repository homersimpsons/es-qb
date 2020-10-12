<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\GeoPoint;
use EsQb\Query\GeoPolygonQuery;
use PHPUnit\Framework\TestCase;

class GeoPolygonQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'geo_polygon' => [
            'boost' => 2.0,
            '_name' => 'queryName',
            'field' => [
                'points' => [
                    ['lat' => 40., 'lon' => -70.],
                    ['lat' => 30., 'lon' => -80.],
                    ['lat' => 20., 'lon' => -90.],
                ],
            ],
            'validation_method' => 'COERCE',
            'ignore_unmapped' => true,
        ],
    ];

    public function testBase(): void
    {
        $this->assertEquals(
            ['geo_polygon' => ['field' => ['points' => []]]],
            (new GeoPolygonQuery('field', []))->toQuery()
        );
    }

    public function testWithAll(): void
    {
        $query = new GeoPolygonQuery(
            'field',
            [new GeoPoint(40., -70.), new GeoPoint(30., -80.), new GeoPoint(20., -90.)]
        );
        $query->setQueryName('queryName');
        $query->setBoost(2.0);
        $query->setValidationMethod('COERCE');
        $query->setIgnoreUnmapped(true);
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
