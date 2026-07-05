<?php

namespace AtlasBuilder\Theme;

defined('ABSPATH') || exit;

class PostType
{
    public function register(): void
    {
        add_action('init', [$this, 'registerPostType']);
    }

    public function registerPostType(): void
    {
        register_post_type('atlas_theme', [

            'labels' => [
                'name'          => 'Temas',
                'singular_name' => 'Tema',
                'add_new_item'  => 'Novo Tema',
                'edit_item'     => 'Editar Tema',
            ],

            'public' => false,

            'show_ui' => true,

            'show_in_menu' => 'atlas-builder',

            'supports' => [
                'title'
            ],

            'menu_position' => 3,

            'menu_icon' => 'dashicons-admin-appearance',

        ]);
    }
}