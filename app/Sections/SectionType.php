<?php

namespace AtlasBuilder\Sections;

defined('ABSPATH') || exit;

interface SectionType
{
    public function key(): string;

    public function label(): string;

    public function fields(): array;

    public function defaults(): array;

    public function render(array $data): string;
}