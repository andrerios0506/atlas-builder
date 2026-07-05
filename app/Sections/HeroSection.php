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

public function render(array $data): string
    {
        $title = esc_html($data['title'] ?? '');
        $subtitle = esc_html($data['subtitle'] ?? '');
        $buttonText = esc_html($data['button_text'] ?? '');
        $buttonUrl = esc_url($data['button_url'] ?? '#');

        $html = '<section class="atlas-section atlas-hero">';
        $html .= '<h1>' . $title . '</h1>';
        $html .= '<p>' . $subtitle . '</p>';
        $html .= '<a class="atlas-button" href="' . $buttonUrl . '">' . $buttonText . '</a>';
        $html .= '</section>';

        return $html;
    }
}