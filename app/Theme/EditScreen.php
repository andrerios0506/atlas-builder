<?php

namespace AtlasBuilder\Theme;

defined('ABSPATH') || exit;

class EditScreen
{
    public function register(): void
    {
        add_action('add_meta_boxes', [$this, 'addMetaBox']);
        add_action('save_post_atlas_theme', [$this, 'saveMetaBox']);
    }

    public function addMetaBox(): void
    {
        add_meta_box(
            'atlas_theme_box',
            'Configurações do Tema',
            [$this, 'render'],
            'atlas_theme',
            'normal',
            'high'
        );
    }

    public function render(\WP_Post $post): void
    {
        $theme = new Theme();
        $data = $theme->get($post->ID);

        wp_nonce_field('atlas_save_theme', 'atlas_theme_nonce');
        ?>
        <?php foreach ($theme->fields() as $field): ?>
            <?php
            $fieldName = $field['name'];
            $fieldValue = $data[$fieldName] ?? '';
            $inputName = "atlas_theme[{$fieldName}]";
            ?>
            <p>
                <label>
                    <strong><?php echo esc_html($field['label']); ?></strong><br>
                    <?php if ($field['type'] === 'color'): ?>
                        <input
                            type="color"
                            name="<?php echo esc_attr($inputName); ?>"
                            value="<?php echo esc_attr($fieldValue); ?>"
                        >
                    <?php else: ?>
                        <input
                            type="text"
                            name="<?php echo esc_attr($inputName); ?>"
                            value="<?php echo esc_attr($fieldValue); ?>"
                            style="width:100%;"
                        >
                    <?php endif; ?>
                </label>
            </p>
        <?php endforeach; ?>
        <?php
    }

    public function saveMetaBox(int $postId): void
    {
        if (!isset($_POST['atlas_theme_nonce'])) {
            return;
        }

        if (!wp_verify_nonce($_POST['atlas_theme_nonce'], 'atlas_save_theme')) {
            return;
        }

        if (!isset($_POST['atlas_theme']) || !is_array($_POST['atlas_theme'])) {
            return;
        }

        $theme = new Theme();
        $data = [];

        foreach ($_POST['atlas_theme'] as $fieldName => $fieldValue) {
            $data[sanitize_key($fieldName)] = sanitize_text_field(
                wp_unslash($fieldValue)
            );
        }

        $theme->save($postId, $data);
    }
}