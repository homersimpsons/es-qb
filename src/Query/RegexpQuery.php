<?php

declare(strict_types=1);

namespace EsQb\Query;

class RegexpQuery extends AbstractQuery implements MultiTermQuery
{
    public const MAX_DETERMINIZED_STATES = 10000;

    private string $field;
    private string $regexp;
    private ?string $flags             = null;
    private int $maxDeterminizedStates = self::MAX_DETERMINIZED_STATES;
    private ?string $rewrite           = null;

    public function __construct(string $field, string $regexp)
    {
        $this->field  = $field;
        $this->regexp = $regexp;
    }

    /**
     * {@inheritDoc}
     */
    protected function doToQuery(): array
    {
        $innerQuery = ['value' => $this->regexp];
        $this->printBoostAndQueryName($innerQuery);
        $this->printIfNotDefault($innerQuery, 'flags', $this->getFlags(), null);
        $this->printIfNotDefault(
            $innerQuery,
            'max_determinized_states',
            $this->getMaxDeterminizedStates(),
            self::MAX_DETERMINIZED_STATES
        );
        $this->printIfNotDefault($innerQuery, 'rewrite', $this->getRewrite(), null);

        return ['regexp' => [$this->field => $innerQuery]];
    }

    public function getFlags(): ?string
    {
        return $this->flags;
    }

    public function setFlags(?string $flags): void
    {
        $this->flags = $flags;
    }

    public function getMaxDeterminizedStates(): int
    {
        return $this->maxDeterminizedStates;
    }

    public function setMaxDeterminizedStates(int $maxDeterminizedStates): void
    {
        $this->maxDeterminizedStates = $maxDeterminizedStates;
    }

    public function getRewrite(): ?string
    {
        return $this->rewrite;
    }

    public function setRewrite(?string $rewrite): void
    {
        $this->rewrite = $rewrite;
    }
}
