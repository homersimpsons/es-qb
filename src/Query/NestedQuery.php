<?php

declare(strict_types=1);

namespace EsQb\Query;

use EsQb\Utils;

final class NestedQuery extends AbstractQuery
{
    public const DEFAULT_SCORE_MODE      = 'avg';
    public const DEFAULT_IGNORE_UNMAPPED = false;

    private string $path;
    private AbstractQuery $query;
    private string $scoreMode;
    private bool $ignoreUnmapped = self::DEFAULT_IGNORE_UNMAPPED;

    public function __construct(string $path, AbstractQuery $query, string $scoreMode = self::DEFAULT_SCORE_MODE)
    {
        $this->path      = $path;
        $this->query     = $query;
        $this->scoreMode = $scoreMode;
    }

    /**
     * @inheritDoc
     */
    protected function doToQuery(): array
    {
        $innerQuery = ['path' => $this->path, 'query' => $this->query->toQuery()];
        $this->printBoostAndQueryName($innerQuery);
        Utils::printIfNotDefault($innerQuery, 'score_mode', $this->getScoreMode(), self::DEFAULT_SCORE_MODE);
        Utils::printIfNotDefault(
            $innerQuery,
            'ignore_unmapped',
            $this->getIgnoreUnmapped(),
            self::DEFAULT_IGNORE_UNMAPPED
        );

        return ['nested' => $innerQuery];
    }

    public function getScoreMode(): string
    {
        return $this->scoreMode;
    }

    public function setScoreMode(string $scoreMode): void
    {
        $this->scoreMode = $scoreMode;
    }

    public function getIgnoreUnmapped(): bool
    {
        return $this->ignoreUnmapped;
    }

    public function setIgnoreUnmapped(bool $ignoreUnmapped): void
    {
        $this->ignoreUnmapped = $ignoreUnmapped;
    }
}
