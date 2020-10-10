<?php

declare(strict_types=1);

namespace EsQb\Integration\Query;

use EsQb\Integration\ArrayQueryWrapper;
use EsQb\Integration\EsQbIntegrationTest;
use EsQb\Unit\Query\PrefixQueryTest as UnitPrefixQueryTest;

class PrefixQueryTest extends EsQbIntegrationTest
{
    public function testBase(): void
    {
        $this->assertValidQuery(new ArrayQueryWrapper(UnitPrefixQueryTest::FULL_QUERY));
    }
}
