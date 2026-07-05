<?php

namespace AtlasBuilder\Landing;

defined('ABSPATH') || exit;

class Document
{
    private const META_KEY = '_atlas_document';

    public function get(int $postId): array
    {
        $raw = get_post_meta($postId, self::META_KEY, true);

        if (empty($raw)) {
            return $this->defaultDocument();
        }

        $decoded = json_decode($raw, true);

        if (!is_array($decoded)) {
            return $this->defaultDocument();
        }

        return $decoded;
    }

    public function save(int $postId, array $document): void
    {
        update_post_meta(
    $postId,
    self::META_KEY,
    wp_json_encode($document, JSON_UNESCAPED_UNICODE)
);
    }

    private function defaultDocument(): array
    {
        return [
            'version'  => '0.1.0-alpha',
            'sections' => [],
        ];
    }
}