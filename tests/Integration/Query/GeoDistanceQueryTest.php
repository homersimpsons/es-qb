<?php

declare(strict_types=1);

namespace EsQb\Integration\Query;

use EsQb\Integration\ArrayQueryWrapper;
use EsQb\Integration\EsQbIntegrationTest;
use EsQb\Unit\Query\GeoDistanceQueryTest as UnitGeoDistanceQueryTest;

class GeoDistanceQueryTest extends EsQbIntegrationTest
{
    public function testBase(): void
    {
        $this->assertValidQuery(new ArrayQueryWrapper(UnitGeoDistanceQueryTest::FULL_QUERY));
    }
}
