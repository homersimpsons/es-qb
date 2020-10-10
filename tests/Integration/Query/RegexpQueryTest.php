<?php

declare(strict_types=1);

namespace EsQb\Integration\Query;

use EsQb\Integration\ArrayQueryWrapper;
use EsQb\Integration\EsQbIntegrationTest;
use EsQb\Unit\Query\RegexpQueryTest as UnitRegexpQueryTest;

class RegexpQueryTest extends EsQbIntegrationTest
{
    public function testBase(): void
    {
        $this->assertValidQuery(new ArrayQueryWrapper(UnitRegexpQueryTest::FULL_QUERY));
    }
}
