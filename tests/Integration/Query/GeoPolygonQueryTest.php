<?php

declare(strict_types=1);

namespace EsQb\Integration\Query;

use EsQb\Integration\ArrayQueryWrapper;
use EsQb\Integration\EsQbIntegrationTest;
use EsQb\Unit\Query\GeoPolygonQueryTest as UnitGeoPolygonQueryTest;

class GeoPolygonQueryTest extends EsQbIntegrationTest
{
    public function testBase(): void
    {
        $this->assertValidQuery(new ArrayQueryWrapper(UnitGeoPolygonQueryTest::FULL_QUERY));
    }
}
