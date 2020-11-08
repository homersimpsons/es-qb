<?php

declare(strict_types=1);

namespace EsQb\Query\FunctionScore;

use EsQb\Utils;

// phpcs:ignore SlevomatCodingStandard.Classes.SuperfluousAbstractClassNaming.SuperfluousPrefix
abstract class AbstractDecayFunction extends AbstractScoreFunction
{
    public const DEFAULT_DECAY = 0.5;

    private string $field;
    private string $scale;
    private string $origin;
    private ?string $offset;
    private float $decay;

    public function __construct(
        string $field,
        string $scale,
        string $origin,
        ?string $offset = null,
        float $decay = self::DEFAULT_DECAY
    ) {
        $this->field  = $field;
        $this->scale  = $scale;
        $this->origin = $origin;
        $this->offset = $offset;
        $this->decay  = $decay;
    }

    /**
     * @return array<string, mixed>
     */
    final protected function doToFunction(): array
    {
        $innerFunctionDesc = ['origin' => $this->getOrigin(), 'scale' => $this->getScale()];
        Utils::printIfNotDefault($innerFunctionDesc, 'offset', $this->getOffset(), null);
        Utils::printIfNotDefault($innerFunctionDesc, 'decay', $this->getDecay(), self::DEFAULT_DECAY);

        return [$this->getDecayFunction() => [$this->getField() => $innerFunctionDesc]];
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getScale(): string
    {
        return $this->scale;
    }

    public function getOrigin(): string
    {
        return $this->origin;
    }

    public function getOffset(): ?string
    {
        return $this->offset;
    }

    public function getDecay(): float
    {
        return $this->decay;
    }

    abstract protected function getDecayFunction(): string;
}
