<?php

declare(strict_types=1);

namespace EsQb;

final class Script
{
    public const DEFAULT_LANG = 'painless';

    private string $lang    = self::DEFAULT_LANG;
    private ?string $source = null;
    private ?string $id     = null;
    /** @var array<string, mixed> */
    private array $params = [];

    /**
     * @return array<string, mixed>
     */
    public function toScript(): array
    {
        $innerScript = [];
        Utils::printIfNotDefault($innerScript, 'lang', $this->getLang(), self::DEFAULT_LANG);
        Utils::printIfNotDefault($innerScript, 'source', $this->getSource(), null);
        Utils::printIfNotDefault($innerScript, 'id', $this->getId(), null);
        Utils::printIfNotDefault($innerScript, 'params', $this->getParams(), []);

        return ['script' => $innerScript];
    }

    public function getLang(): string
    {
        return $this->lang;
    }

    public function setLang(string $lang): void
    {
        $this->lang = $lang;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(?string $source): void
    {
        $this->source = $source;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return array<string, mixed>
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param array<string, mixed> $params
     */
    public function setParams(array $params): void
    {
        $this->params = $params;
    }
}
