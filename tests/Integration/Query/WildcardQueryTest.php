<?php

declare(strict_types=1);

namespace EsQb\Integration\Query;

use EsQb\Integration\ArrayQueryWrapper;
use EsQb\Integration\EsQbIntegrationTest;
use EsQb\Unit\Query\WildcardQueryTest as UnitWildcardQueryTest;

class WildcardQueryTest extends EsQbIntegrationTest
{
    public function testBase(): void
    {
        $this->assertValidQuery(new ArrayQueryWrapper(UnitWildcardQueryTest::FULL_QUERY));
    }
}
