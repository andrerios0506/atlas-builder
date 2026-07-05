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

    public function render(array $data): string
    {
        $imageUrl = esc_url($data['image_url'] ?? '');
        $heading = esc_html($data['heading'] ?? '');
        $body = wpautop(esc_html($data['body'] ?? ''));

        $imageHtml = '';
        if ($imageUrl !== '') {
            $imageHtml = '<img src="' . $imageUrl . '" alt="' . $heading . '">';
        }

        $html = '<section class="atlas-section atlas-image-text">';
        $html .= '<div class="atlas-image-text-image">' . $imageHtml . '</div>';
        $html .= '<div class="atlas-image-text-content">';
        $html .= '<h2>' . $heading . '</h2>';
        $html .= $body;
        $html .= '</div>';
        $html .= '</section>';

        return $html;
    }
}