<?php

namespace AtlasBuilder\Landing;

defined('ABSPATH') || exit;

class EditScreen
{
    public function register(): void
    {
        add_action('add_meta_boxes', [$this, 'addMetaBox']);
        add_action('save_post_atlas_landing', [$this, 'saveMetaBox']);
    }

    public function addMetaBox(): void
    {
        add_meta_box(
            'atlas_document_box',
            'Atlas Builder — Documento',
            [$this, 'render'],
            'atlas_landing',
            'normal',
            'high'
        );
    }

    public function render(\WP_Post $post): void
    {
        $document = new Document();
        $data = $document->get($post->ID);

        wp_nonce_field('atlas_save_document', 'atlas_document_nonce');

        $json = wp_json_encode($data, JSON_PRETTY_PRINT);
        ?>
        <p>
            <strong>Documento atual (JSON):</strong><br>
            Este é um teste de leitura/escrita. O editor visual substituirá este campo em breve.
        </p>
        <textarea
            name="atlas_document_json"
            rows="15"
            style="width: 100%; font-family: monospace;"
        ><?php echo esc_textarea($json); ?></textarea>
        <?php
    }

    public function saveMetaBox(int $postId): void
    {
        if (!isset($_POST['atlas_document_nonce'])) {
            return;
        }

        if (!wp_verify_nonce($_POST['atlas_document_nonce'], 'atlas_save_document')) {
            return;
        }

        if (!isset($_POST['atlas_document_json'])) {
            return;
        }

        $raw = wp_unslash($_POST['atlas_document_json']);
        $decoded = json_decode($raw, true);

        if (!is_array($decoded)) {
            return;
        }

        (new Document())->save($postId, $decoded);
    }
}