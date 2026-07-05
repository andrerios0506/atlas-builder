<?php

namespace AtlasBuilder\Sections;

defined('ABSPATH') || exit;

class Registry
{
    /** @var SectionType[] */
    private array $types = [];

    public function register(SectionType $type): void
    {
        $this->types[$type->key()] = $type;
    }

    public function all(): array
    {
        return $this->types;
    }

    public function get(string $key): ?SectionType
    {
        return $this->types[$key] ?? null;
    }
}