<?php

declare(strict_types=1);

namespace EsQb\Integration\Query;

use EsQb\Integration\ArrayQueryWrapper;
use EsQb\Integration\EsQbIntegrationTest;
use EsQb\Unit\Query\GeoBoundingBoxQueryTest as UnitGeoBoundingBoxQueryTest;

class GeoBoundingBoxQueryTest extends EsQbIntegrationTest
{
    public function testBase(): void
    {
        $this->assertValidQuery(new ArrayQueryWrapper(UnitGeoBoundingBoxQueryTest::FULL_QUERY));
    }
}
