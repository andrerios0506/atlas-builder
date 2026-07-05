<?php

namespace AtlasBuilder\Landing;

defined('ABSPATH') || exit;

class PostType
{
    public function register(): void
    {
        add_action('init', [$this, 'registerPostType']);
        add_action('save_post_atlas_landing', [$this, 'ensureDocument']);
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

            'public' => true,

            'publicly_queryable' => true,

            'show_ui' => true,

            'show_in_menu' => 'atlas-builder',

            'show_in_nav_menus' => false,

            'has_archive' => false,

            'rewrite' => ['slug' => 'landing'],

            'supports' => [
                'title'
            ],

            'menu_position' => 2,

            'menu_icon' => 'dashicons-layout',

        ]);
    }

    public function ensureDocument(int $postId): void
    {
        if (wp_is_post_revision($postId)) {
            return;
        }

        $document = new Document();

        $existing = get_post_meta($postId, '_atlas_document', true);

        if (empty($existing)) {
            $document->save($postId, [
                'version'  => '0.1.0-alpha',
                'sections' => [],
            ]);
        }
    }
}