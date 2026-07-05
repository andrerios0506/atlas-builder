<?php

namespace AtlasBuilder\Sections;

defined('ABSPATH') || exit;

class ImageTextSection implements SectionType
{
    public function key(): string
    {
        return 'image_text';
    }

    public function label(): string
    {
        return 'Imagem + Texto';
    }

    public function fields(): array
    {
        return [
            [
                'name'  => 'image_url',
                'label' => 'URL da Imagem',
                'type'  => 'text',
            ],
            [
                'name'  => 'heading',
                'label' => 'Título',
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
            'image_url' => '',
            'heading'   => 'Título da seção',
            'body'      => 'Descrição ao lado da imagem.',
        ];
    }
}