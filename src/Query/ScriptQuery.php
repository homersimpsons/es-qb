<?php

declare(strict_types=1);

namespace EsQb\Query;

use EsQb\Script;

final class ScriptQuery extends AbstractQuery
{
    private Script $script;

    public function __construct(Script $script)
    {
        $this->script = $script;
    }

    /**
     * @inheritDoc
     */
    protected function doToQuery(): array
    {
        $innerQuery = $this->script->toScript();
        $this->printBoostAndQueryName($innerQuery);

        return ['script' => $innerQuery];
    }
}
