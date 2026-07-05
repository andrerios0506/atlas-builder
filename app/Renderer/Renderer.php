<?php

namespace AtlasBuilder\Renderer;

defined('ABSPATH') || exit;

use AtlasBuilder\Landing\Document;
use AtlasBuilder\Sections\Registry;

class Renderer
{
    public function __construct(private Registry $sections)
    {
    }

    public function render(int $postId): string
    {
        $document = (new Document())->get($postId);
        $sections = $document['sections'] ?? [];

        $title = esc_html(get_the_title($postId));

        $sectionsHtml = '';

        foreach ($sections as $section) {
            $key = $section['type'] ?? null;
            $type = $key ? $this->sections->get($key) : null;

            if ($type === null) {
                continue;
            }

            $sectionsHtml .= $type->render($section['data'] ?? []);
        }

        $css = $this->css();

        $html = '<!DOCTYPE html>';
        $html .= '<html lang="pt-BR">';
        $html .= '<head>';
        $html .= '<meta charset="UTF-8">';
        $html .= '<title>' . $title . '</title>';
        $html .= '<style>' . $css . '</style>';
        $html .= '</head>';
        $html .= '<body>';
        $html .= $sectionsHtml;
        $html .= '</body>';
        $html .= '</html>';

        return $html;
    }

    private function css(): string
    {
        $css = '* { box-sizing: border-box; }';
        $css .= 'body { margin: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; color: #222; line-height: 1.6; }';
        $css .= 'img { max-width: 100%; height: auto; display: block; }';

        $css .= '.atlas-section { padding: 60px 20px; max-width: 800px; margin: 0 auto; }';

        $css .= '.atlas-hero { text-align: center; }';
        $css .= '.atlas-hero h1 { font-size: 2.5em; margin-bottom: 10px; }';
        $css .= '.atlas-button { display: inline-block; margin-top: 20px; padding: 12px 28px; background: #2271b1; color: #fff; text-decoration: none; border-radius: 4px; }';

        $css .= '.atlas-image-text { display: flex; gap: 30px; align-items: center; }';
        $css .= '.atlas-image-text-image img { border-radius: 6px; }';
        $css .= '.atlas-image-text-image, .atlas-image-text-content { flex: 1; min-width: 0; }';

        $css .= '.atlas-testimonial { text-align: center; font-style: italic; }';
        $css .= '.atlas-testimonial blockquote { font-size: 1.3em; margin: 0 0 15px; }';
        $css .= '.atlas-author { font-style: normal; font-weight: bold; }';
        $css .= '.atlas-author-role { font-weight: normal; color: #666; }';
        $css .= '.atlas-lead-capture { text-align: center; }';
        $css .= '.atlas-lead-form { display: flex; flex-direction: column; gap: 12px; max-width: 400px; margin: 20px auto 0; }';
        $css .= '.atlas-input { padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 1em; }';
        $css .= '.atlas-faq-item { border-bottom: 1px solid #e0e0e0; padding: 16px 0; }';
        $css .= '.atlas-faq-question { font-weight: bold; margin: 0 0 8px; }';
        $css .= '.atlas-faq-answer { margin: 0; color: #444; }';

        // Responsividade — telas médias (tablets)
        $css .= '@media (max-width: 768px) {';
        $css .= '  .atlas-section { padding: 40px 20px; }';
        $css .= '  .atlas-hero h1 { font-size: 2em; }';
        $css .= '}';

        // Responsividade — telas pequenas (celular)
        $css .= '@media (max-width: 480px) {';
        $css .= '  .atlas-section { padding: 30px 16px; }';
        $css .= '  .atlas-hero h1 { font-size: 1.6em; }';
        $css .= '  .atlas-hero p { font-size: 0.95em; }';
        $css .= '  .atlas-button { width: 100%; text-align: center; }';
        $css .= '  .atlas-image-text { flex-direction: column; }';
        $css .= '  .atlas-testimonial blockquote { font-size: 1.1em; }';
        $css .= '}';

        return $css;
    }
}    