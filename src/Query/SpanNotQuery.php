<?php

declare(strict_types=1);

namespace EsQb\Query;

use EsQb\Utils;

final class SpanNotQuery extends AbstractQuery implements SpanQuery
{
    private SpanQuery $include;
    private SpanQuery $exclude;
    private ?int $pre  = null;
    private ?int $post = null;
    private ?int $dist = null;

    public function __construct(SpanQuery $include, SpanQuery $exclude)
    {
        $this->include = $include;
        $this->exclude = $exclude;
    }

    /**
     * @inheritDoc
     */
    protected function doToQuery(): array
    {
        $innerQuery = [
            'include' => $this->include->toQuery(),
            'exclude' => $this->exclude->toQuery(),
        ];
        $this->printBoostAndQueryName($innerQuery);
        Utils::printIfNotDefault($innerQuery, 'pre', $this->getPre(), null);
        Utils::printIfNotDefault($innerQuery, 'post', $this->getPost(), null);
        Utils::printIfNotDefault($innerQuery, 'dist', $this->getDist(), null);

        return ['span_not' => $innerQuery];
    }

    public function getPre(): ?int
    {
        return $this->pre;
    }

    public function setPre(?int $pre): void
    {
        $this->pre = $pre;
    }

    public function getPost(): ?int
    {
        return $this->post;
    }

    public function setPost(?int $post): void
    {
        $this->post = $post;
    }

    public function getDist(): ?int
    {
        return $this->dist;
    }

    public function setDist(?int $dist): void
    {
        $this->dist = $dist;
    }
}
