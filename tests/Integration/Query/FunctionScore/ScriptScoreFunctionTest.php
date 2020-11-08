<?php

declare(strict_types=1);

namespace EsQb\Integration\Query\FunctionScore;

use EsQb\Integration\ArrayQueryWrapper;
use EsQb\Integration\EsQbIntegrationTest;
use EsQb\Unit\Query\FunctionScore\ScriptScoreFunctionTest as UnitScriptScoreFunctionTest;

class ScriptScoreFunctionTest extends EsQbIntegrationTest
{
    public function testBase(): void
    {
        $this->assertValidQuery(
            new ArrayQueryWrapper(['function_score' => UnitScriptScoreFunctionTest::FULL_FUNCTION])
        );
    }
}
