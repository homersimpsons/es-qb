<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\GeoPoint;
use EsQb\Query\GeoBoundingBoxQuery;
use PHPUnit\Framework\TestCase;

class GeoBoundingBoxQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'geo_bounding_box' => [
            'boost' => 2.0,
            '_name' => 'queryName',
            'field' => [
                'top' => 11.,
                'left' => 12.,
                'bottom' => 10.,
                'right' => 13.,
            ],
            'type' => 'indexed',
            'validation_method' => 'COERCE',
            'ignore_unmapped' => true,
        ],
    ];

    public function testBase(): void
    {
        $this->assertEquals(
            [
                'geo_bounding_box' => [
                    'field' => [
                        'top' => 11.,
                        'left' => 12.,
                        'bottom' => 10.,
                        'right' => 13.,
                    ],
                ],
            ],
            (new GeoBoundingBoxQuery('field', new GeoPoint(11., 12.), new GeoPoint(10., 13.)))->toQuery()
        );
    }

    public function testWithAll(): void
    {
        $query = new GeoBoundingBoxQuery('field', new GeoPoint(11., 12.), new GeoPoint(10., 13.));
        $query->setQueryName('queryName');
        $query->setBoost(2.0);
        $query->setType('indexed');
        $query->setValidationMethod('COERCE');
        $query->setIgnoreUnmapped(true);
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
