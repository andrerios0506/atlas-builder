<?php

namespace AtlasBuilder\Landing;

defined('ABSPATH') || exit;

use AtlasBuilder\Sections\Registry;

class EditScreen
{
    public function __construct(private Registry $sections)
    {
    }

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

        $sections = $data['sections'] ?? [];
        ?>
        <p><strong>Seções desta Landing Page</strong></p>

        <?php if (empty($sections)): ?>
            <p><em>Nenhuma seção adicionada ainda.</em></p>
        <?php else: ?>
            <ol>
                <?php foreach ($sections as $section): ?>
                    <li>
                        <strong><?php echo esc_html($section['type'] ?? '???'); ?></strong>
                        —
                        <?php echo esc_html($section['data']['title'] ?? '(sem título)'); ?>
                    </li>
                <?php endforeach; ?>
            </ol>
        <?php endif; ?>

        <hr>

        <p><strong>Adicionar nova seção:</strong></p>

        <?php foreach ($this->sections->all() as $type): ?>
            <button
                type="submit"
                name="atlas_add_section"
                value="<?php echo esc_attr($type->key()); ?>"
                class="button"
            >
                + <?php echo esc_html($type->label()); ?>
            </button>
        <?php endforeach; ?>

        <input type="hidden" name="atlas_sections_json" value="<?php echo esc_attr(wp_json_encode($sections, JSON_UNESCAPED_UNICODE)); ?>">
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

        $sections = [];

        if (isset($_POST['atlas_sections_json'])) {
            $decoded = json_decode(wp_unslash($_POST['atlas_sections_json']), true);

            if (is_array($decoded)) {
                $sections = $decoded;
            }
        }

        if (isset($_POST['atlas_add_section'])) {
            $key = sanitize_text_field($_POST['atlas_add_section']);
            $type = $this->sections->get($key);

            if ($type !== null) {
                $sections[] = [
                    'type' => $type->key(),
                    'data' => $type->defaults(),
                ];
            }
        }

        $document = new Document();
        $current = $document->get($postId);
        $current['sections'] = $sections;

        $document->save($postId, $current);
    }
}