<?php

declare(strict_types=1);

namespace EsQb\Integration\Query;

use EsQb\Integration\ArrayQueryWrapper;
use EsQb\Integration\EsQbIntegrationTest;
use EsQb\Unit\Query\IdsQueryTest as UnitIdsQueryTest;

class IdsQueryTest extends EsQbIntegrationTest
{
    public function testBase(): void
    {
        $this->assertValidQuery(new ArrayQueryWrapper(UnitIdsQueryTest::FULL_QUERY));
    }
}
