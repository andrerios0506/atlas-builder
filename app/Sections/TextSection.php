<?php

namespace AtlasBuilder\Sections;

defined('ABSPATH') || exit;

class TextSection implements SectionType
{
    public function key(): string
    {
        return 'text';
    }

    public function label(): string
    {
        return 'Texto';
    }

    public function fields(): array
    {
        return [
            [
                'name'  => 'heading',
                'label' => 'Título (opcional)',
                'type'  => 'text',
            ],
            [
                'name'  => 'body',
                'label' => 'Texto',
                'type'  => 'textarea',
            ],
        ];
    }

    public function defaults(): array
    {
        return [
            'heading' => '',
            'body'    => 'Escreva aqui o conteúdo desta seção.',
        ];
    }
}