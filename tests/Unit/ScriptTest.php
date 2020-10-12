<?php

declare(strict_types=1);

namespace EsQb\Unit;

use EsQb\Script;
use PHPUnit\Framework\TestCase;

class ScriptTest extends TestCase
{
    public function testScript(): void
    {
        $script = new Script();
        $script->setLang('myLang');
        $script->setId('myId');
        $script->setSource('mySource');
        $script->setParams(['multiplier' => 2]);
        $this->assertEquals(
            ['script' => ['lang' => 'myLang', 'id' => 'myId', 'source' => 'mySource', 'params' => ['multiplier' => 2]]],
            $script->toScript()
        );
    }
}
