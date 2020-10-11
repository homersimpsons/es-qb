<?php

declare(strict_types=1);

namespace EsQb\Integration\Query;

use EsQb\Integration\ArrayQueryWrapper;
use EsQb\Integration\EsQbIntegrationTest;
use EsQb\Unit\Query\SimpleQueryStringQueryTest as UnitSimpleQueryStringQueryTest;

class SimpleQueryStringQueryTest extends EsQbIntegrationTest
{
    public function testBase(): void
    {
        $this->assertValidQuery(new ArrayQueryWrapper(UnitSimpleQueryStringQueryTest::FULL_QUERY));
    }
}
