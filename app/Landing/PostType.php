<?php

namespace AtlasBuilder\Landing;

defined('ABSPATH') || exit;

class PostType
{
    public function register(): void
    {
        add_action('init', [$this, 'registerPostType']);
    }

    public function registerPostType(): void
    {
        register_post_type('atlas_landing', [

            'labels' => [
                'name'          => 'Landing Pages',
                'singular_name' => 'Landing Page',
                'add_new_item'  => 'Nova Landing Page',
                'edit_item'     => 'Editar Landing Page',
            ],

            'public' => false,

            'show_ui' => true,

            'show_in_menu' => 'atlas-builder',

            'supports' => [
                'title'
            ],

            'menu_position' => 2,

            'menu_icon' => 'dashicons-layout',

        ]);
    }
}