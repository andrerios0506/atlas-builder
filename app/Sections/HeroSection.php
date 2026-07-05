<?php

namespace AtlasBuilder\Sections;

defined('ABSPATH') || exit;

class HeroSection implements SectionType
{
    public function key(): string
    {
        return 'hero';
    }

    public function label(): string
    {
        return 'Hero (Título + Botão)';
    }

    public function fields(): array
    {
        return [
            [
                'name'  => 'title',
                'label' => 'Título',
                'type'  => 'text',
            ],
            [
                'name'  => 'subtitle',
                'label' => 'Subtítulo',
                'type'  => 'textarea',
            ],
            [
                'name'  => 'button_text',
                'label' => 'Texto do Botão',
                'type'  => 'text',
            ],
            [
                'name'  => 'button_url',
                'label' => 'Link do Botão',
                'type'  => 'text',
            ],
        ];
    }

    public function defaults(): array
    {
        return [
            'title'       => 'Seu título aqui',
            'subtitle'    => 'Seu subtítulo aqui',
            'button_text' => 'Clique aqui',
            'button_url'  => '#',
        ];
    }
}