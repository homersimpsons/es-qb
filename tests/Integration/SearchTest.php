<?php

declare(strict_types=1);

namespace EsQb\Integration;

use EsQb\Unit\SearchTest as UnitSearchTest;

final class SearchTest extends EsQbIntegrationTest
{
    public function testSearch(): void
    {
        $fullSearchGetWithoutScroll = UnitSearchTest::FULL_SEARCH_GET;
        unset($fullSearchGetWithoutScroll['scroll'], $fullSearchGetWithoutScroll['suggest_field']);
        $this->validateSearchParams($fullSearchGetWithoutScroll);
        $fullSearchGetWithScroll = UnitSearchTest::FULL_SEARCH_GET;
        unset(
            $fullSearchGetWithScroll['from'],
            $fullSearchGetWithScroll['request_cache'],
            $fullSearchGetWithScroll['suggest_field']
        );
        $this->validateSearchParams($fullSearchGetWithScroll);
        $this->validateSearchParams(UnitSearchTest::FULL_SEARCH_BODY);
        $this->assertTrue(true);
    }
}
