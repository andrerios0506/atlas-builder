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
        $sections = $data['sections'] ?? [];

        wp_nonce_field('atlas_save_document', 'atlas_document_nonce');
        ?>
        <p><strong>Seções desta Landing Page</strong></p>

        <?php if (empty($sections)): ?>
            <p><em>Nenhuma seção adicionada ainda.</em></p>
        <?php else: ?>
            <?php foreach ($sections as $index => $section): ?>
                <?php
                $sectionKey = $section['type'] ?? null;
                $type = $sectionKey ? $this->sections->get($sectionKey) : null;
                ?>
                <div style="border:1px solid #ccd0d4; padding:12px; margin-bottom:12px; background:#fff;">
                    <p>
                        <strong>
                            <?php echo esc_html($type ? $type->label() : ($sectionKey ?? 'Seção desconhecida')); ?>
                        </strong>
                        <button
                            type="submit"
                            name="atlas_remove_section"
                            value="<?php echo esc_attr($index); ?>"
                            class="button"
                            style="float:right;"
                            onclick="return confirm('Remover esta seção?');"
                        >
                            Remover
                        </button>
                    </p>

                    <input type="hidden" name="atlas_sections[<?php echo esc_attr($index); ?>][type]" value="<?php echo esc_attr($sectionKey); ?>">

                    <?php if ($type): ?>
                        <?php foreach ($type->fields() as $field): ?>
                            <?php
                            $fieldName = $field['name'];
                            $fieldValue = $section['data'][$fieldName] ?? '';
                            $inputName = "atlas_sections[{$index}][data][{$fieldName}]";
                            ?>
                            <p>
                                <label>
                                    <strong><?php echo esc_html($field['label']); ?></strong><br>
                                    <?php if ($field['type'] === 'textarea'): ?>
                                        <textarea
                                            name="<?php echo esc_attr($inputName); ?>"
                                            rows="3"
                                            style="width:100%;"
                                        ><?php echo esc_textarea($fieldValue); ?></textarea>
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
                    <?php else: ?>
                        <p><em>Tipo de seção não reconhecido.</em></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
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

        if (isset($_POST['atlas_sections']) && is_array($_POST['atlas_sections'])) {
            foreach ($_POST['atlas_sections'] as $index => $raw) {
                $type = sanitize_text_field($raw['type'] ?? '');

                if ($type === '') {
                    continue;
                }

                $fieldsData = [];

                if (isset($raw['data']) && is_array($raw['data'])) {
                    foreach ($raw['data'] as $fieldName => $fieldValue) {
                        $fieldsData[sanitize_key($fieldName)] = sanitize_textarea_field(
                            wp_unslash($fieldValue)
                        );
                    }
                }

                $sections[] = [
                    'type' => $type,
                    'data' => $fieldsData,
                ];
            }
        }

        if (isset($_POST['atlas_remove_section'])) {
            $removeIndex = (int) $_POST['atlas_remove_section'];
            unset($sections[$removeIndex]);
            $sections = array_values($sections);
        }

        if (isset($_POST['atlas_add_section'])) {
            $key = sanitize_text_field($_POST['atlas_add_section']);
            $sectionType = $this->sections->get($key);

            if ($sectionType !== null) {
                $sections[] = [
                    'type' => $sectionType->key(),
                    'data' => $sectionType->defaults(),
                ];
            }
        }

        $document = new Document();
        $current = $document->get($postId);
        $current['sections'] = $sections;

        $document->save($postId, $current);
    }
}