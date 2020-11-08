<?php

declare(strict_types=1);

namespace EsQb\Query\FunctionScore;

use EsQb\Script;

final class ScriptScoreFunction extends AbstractScoreFunction
{
    private Script $script;

    public function __construct(Script $script)
    {
        $this->script = $script;
    }

    /**
     * @inheritDoc
     */
    protected function doToFunction(): array
    {
        return ['script_score' => $this->script->toScript()];
    }
}
