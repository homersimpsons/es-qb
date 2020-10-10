<?php

declare(strict_types=1);

namespace EsQb\Integration\Query;

use EsQb\Integration\ArrayQueryWrapper;
use EsQb\Integration\EsQbIntegrationTest;
use EsQb\Unit\Query\DistanceFeatureQueryTest as UnitDistanceFeatureQueryTest;

class DistanceFeatureQueryTest extends EsQbIntegrationTest
{
    public function testBase(): void
    {
        $this->assertValidQuery(new ArrayQueryWrapper(UnitDistanceFeatureQueryTest::FULL_QUERY));
    }
}
