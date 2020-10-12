<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\GeoPoint;
use EsQb\Query\GeoDistanceQuery;
use PHPUnit\Framework\TestCase;

class GeoDistanceQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'geo_distance' => [
            'boost' => 2.0,
            '_name' => 'queryName',
            'field' => ['lat' => 11. ,'lon' => 12.],
            'distance' => '12km',
            'distance_type' => 'plane',
            'validation_method' => 'COERCE',
            'ignore_unmapped' => true,
        ],
    ];

    public function testBase(): void
    {
        $this->assertEquals(
            ['geo_distance' => ['field' => ['lat' => 11., 'lon' => 12.], 'distance' => '12km']],
            (new GeoDistanceQuery('field', new GeoPoint(11., 12.), '12km'))->toQuery()
        );
    }

    public function testWithAll(): void
    {
        $query = new GeoDistanceQuery('field', new GeoPoint(11., 12.), '12km');
        $query->setQueryName('queryName');
        $query->setBoost(2.0);
        $query->setDistanceType('plane');
        $query->setValidationMethod('COERCE');
        $query->setIgnoreUnmapped(true);
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
