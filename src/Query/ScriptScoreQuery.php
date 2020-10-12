<?php

declare(strict_types=1);

namespace EsQb\Query;

use EsQb\Script;

final class ScriptScoreQuery extends AbstractQuery
{
    private AbstractQuery $query;
    private Script $script;

    public function __construct(AbstractQuery $query, Script $script)
    {
        $this->query  = $query;
        $this->script = $script;
    }

    /**
     * @inheritDoc
     */
    protected function doToQuery(): array
    {
        $innerQuery          = $this->script->toScript();
        $innerQuery['query'] = $this->query->toQuery();
        $this->printBoostAndQueryName($innerQuery);

        return ['script_score' => $innerQuery];
    }
}
