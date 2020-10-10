<?php

declare(strict_types=1);

namespace EsQb\Integration\Query;

use EsQb\Integration\ArrayQueryWrapper;
use EsQb\Integration\EsQbIntegrationTest;
use EsQb\Unit\Query\MatchPhraseQueryTest as UnitMatchPhraseQueryTest;

class MatchPhraseQueryTest extends EsQbIntegrationTest
{
    public function testBase(): void
    {
        $this->assertValidQuery(new ArrayQueryWrapper(UnitMatchPhraseQueryTest::FULL_QUERY));
    }
}
