<?php

namespace AtlasBuilder\Sections;

defined('ABSPATH') || exit;

class TestimonialSection implements SectionType
{
    public function key(): string
    {
        return 'testimonial';
    }

    public function label(): string
    {
        return 'Depoimento';
    }

    public function fields(): array
    {
        return [
            [
                'name'  => 'quote',
                'label' => 'Depoimento',
                'type'  => 'textarea',
            ],
            [
                'name'  => 'author_name',
                'label' => 'Nome do Autor',
                'type'  => 'text',
            ],
            [
                'name'  => 'author_role',
                'label' => 'Cargo / Contexto (opcional)',
                'type'  => 'text',
            ],
        ];
    }

    public function defaults(): array
    {
        return [
            'quote'       => 'Este produto mudou minha vida.',
            'author_name' => 'Nome do Cliente',
            'author_role' => '',
        ];
    }
}