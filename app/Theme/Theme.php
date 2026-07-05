<?php

namespace AtlasBuilder\Theme;

defined('ABSPATH') || exit;

class Theme
{
    private const META_KEY = '_atlas_theme_data';

    public function get(int $postId): array
    {
        $raw = get_post_meta($postId, self::META_KEY, true);

        if (empty($raw) || !is_array($raw)) {
            return $this->defaults();
        }

        return array_merge($this->defaults(), $raw);
    }

    public function save(int $postId, array $data): void
    {
        update_post_meta($postId, self::META_KEY, $data);
    }

    public function defaults(): array
    {
        return [
            'primary_color'    => '#2271b1',
            'text_color'       => '#222222',
            'background_color' => '#ffffff',
            'muted_color'      => '#666666',
            'font_family'      => 'Poppins',
        ];
    }

    public function fields(): array
    {
        return [
            ['name' => 'primary_color', 'label' => 'Cor Principal (botões, destaques)', 'type' => 'color'],
            ['name' => 'text_color', 'label' => 'Cor do Texto', 'type' => 'color'],
            ['name' => 'background_color', 'label' => 'Cor de Fundo', 'type' => 'color'],
            ['name' => 'muted_color', 'label' => 'Cor de Texto Secundário (subtítulos, legendas)', 'type' => 'color'],
            ['name' => 'font_family', 'label' => 'Fonte', 'type' => 'font_select'],
        ];
    }

    public function availableFonts(): array
    {
        return [
            'Poppins'          => "'Poppins', sans-serif",
            'Montserrat'       => "'Montserrat', sans-serif",
            'Inter'            => "'Inter', sans-serif",
            'Playfair Display' => "'Playfair Display', serif",
            'Lato'             => "'Lato', sans-serif",
            'Merriweather'     => "'Merriweather', serif",
        ];
    }
}