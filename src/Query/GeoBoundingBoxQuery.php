<?php

declare(strict_types=1);

namespace EsQb\Query;

use EsQb\GeoPoint;
use EsQb\Utils;

final class GeoBoundingBoxQuery extends AbstractQuery
{
    public const DEFAULT_TYPE              = 'memory';
    public const DEFAULT_VALIDATION_METHOD = 'STRICT';

    private string $field;
    private GeoPoint $topLeft;
    private GeoPoint $bottomRight;
    private string $type             = self::DEFAULT_TYPE;
    private string $validationMethod = self::DEFAULT_VALIDATION_METHOD;
    private ?bool $ignoreUnmapped    = null;

    public function __construct(string $field, GeoPoint $topLeft, GeoPoint $bottomRight)
    {
        $this->field       = $field;
        $this->topLeft     = $topLeft;
        $this->bottomRight = $bottomRight;
    }

    /**
     * {@inheritDoc}
     */
    protected function doToQuery(): array
    {
        $innerQuery = [
            $this->field => [
                'top' => $this->topLeft->getLat(),
                'left' => $this->topLeft->getLon(),
                'bottom' => $this->bottomRight->getLat(),
                'right' => $this->bottomRight->getLon(),
            ],
        ];
        $this->printBoostAndQueryName($innerQuery);
        Utils::printIfNotDefault($innerQuery, 'type', $this->getType(), self::DEFAULT_TYPE);
        Utils::printIfNotDefault(
            $innerQuery,
            'validation_method',
            $this->getValidationMethod(),
            self::DEFAULT_VALIDATION_METHOD
        );
        Utils::printIfNotDefault($innerQuery, 'ignore_unmapped', $this->getIgnoreUnmapped(), null);

        return ['geo_bounding_box' => $innerQuery];
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getValidationMethod(): string
    {
        return $this->validationMethod;
    }

    public function setValidationMethod(string $validationMethod): void
    {
        $this->validationMethod = $validationMethod;
    }

    public function getIgnoreUnmapped(): ?bool
    {
        return $this->ignoreUnmapped;
    }

    public function setIgnoreUnmapped(?bool $ignoreUnmapped): void
    {
        $this->ignoreUnmapped = $ignoreUnmapped;
    }
}
