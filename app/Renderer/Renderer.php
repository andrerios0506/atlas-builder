<?php

namespace AtlasBuilder\Renderer;

defined('ABSPATH') || exit;

use AtlasBuilder\Landing\Document;
use AtlasBuilder\Sections\Registry;
use AtlasBuilder\Theme\Theme;

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

        $theme = new Theme();

        $themeId = (int) get_post_meta($postId, '_atlas_theme_id', true);
        $themeData = $themeId ? $theme->get($themeId) : $theme->defaults();

        $fontName = $themeData['font_family'] ?? 'Poppins';
        $availableFonts = $theme->availableFonts();
        $fontCss = $availableFonts[$fontName] ?? $availableFonts['Poppins'];

        $googleFontUrl = $this->googleFontUrl($fontName);

        $sectionsHtml = '';

        foreach ($sections as $section) {
            $key = $section['type'] ?? null;
            $type = $key ? $this->sections->get($key) : null;

            if ($type === null) {
                continue;
            }

            $sectionsHtml .= $type->render($section['data'] ?? []);
        }

        $css = $this->css($themeData, $fontCss);

        $html = '<!DOCTYPE html>';
        $html .= '<html lang="pt-BR">';
        $html .= '<head>';
        $html .= '<meta charset="UTF-8">';
        $html .= '<title>' . $title . '</title>';
        $html .= '<link rel="preconnect" href="https://fonts.googleapis.com">';
        $html .= '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
        $html .= '<link href="' . esc_url($googleFontUrl) . '" rel="stylesheet">';
        $html .= '<style>' . $css . '</style>';
        $html .= '</head>';
        $html .= '<body>';
        $html .= $sectionsHtml;
        $html .= '</body>';
        $html .= '</html>';

        return $html;
    }

    private function css(array $theme, string $fontCss): string
    {
        $primary = esc_attr($theme['primary_color']);
        $text = esc_attr($theme['text_color']);
        $background = esc_attr($theme['background_color']);
        $muted = esc_attr($theme['muted_color']);
        $font = $fontCss;

        $css = ':root {';
        $css .= '--atlas-primary: ' . $primary . ';';
        $css .= '--atlas-text: ' . $text . ';';
        $css .= '--atlas-background: ' . $background . ';';
        $css .= '--atlas-muted: ' . $muted . ';';
        $css .= '--atlas-font: ' . $font . ';';
        $css .= '}';

        $css .= '* { box-sizing: border-box; }';
        $css .= 'body { margin: 0; font-family: var(--atlas-font); color: var(--atlas-text); background: var(--atlas-background); line-height: 1.6; }';
        $css .= 'img { max-width: 100%; height: auto; display: block; }';

        $css .= '.atlas-section { padding: 60px 20px; max-width: 800px; margin: 0 auto; }';

        $css .= '.atlas-hero { text-align: center; }';
        $css .= '.atlas-hero h1 { font-size: 2.5em; margin-bottom: 10px; }';
        $css .= '.atlas-button { display: inline-block; margin-top: 20px; padding: 12px 28px; background: var(--atlas-primary); color: #fff; text-decoration: none; border-radius: 4px; border: none; cursor: pointer; font-size: 1em; }';

        $css .= '.atlas-image-text { display: flex; gap: 30px; align-items: center; }';
        $css .= '.atlas-image-text-image img { border-radius: 6px; }';
        $css .= '.atlas-image-text-image, .atlas-image-text-content { flex: 1; min-width: 0; }';

        $css .= '.atlas-testimonial { text-align: center; font-style: italic; }';
        $css .= '.atlas-testimonial blockquote { font-size: 1.3em; margin: 0 0 15px; }';
        $css .= '.atlas-author { font-style: normal; font-weight: bold; }';
        $css .= '.atlas-author-role { font-weight: normal; color: var(--atlas-muted); }';

        $css .= '.atlas-lead-capture { text-align: center; }';
        $css .= '.atlas-lead-form { display: flex; flex-direction: column; gap: 12px; max-width: 400px; margin: 20px auto 0; }';
        $css .= '.atlas-input { padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 1em; font-family: var(--atlas-font); }';

        $css .= '.atlas-faq-item { border-bottom: 1px solid #e0e0e0; padding: 16px 0; }';
        $css .= '.atlas-faq-question { font-weight: bold; margin: 0 0 8px; }';
        $css .= '.atlas-faq-answer { margin: 0; color: var(--atlas-muted); }';

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

    private function googleFontUrl(string $fontName): string
    {
        $family = str_replace(' ', '+', $fontName);

        return "https://fonts.googleapis.com/css2?family={$family}:wght@400;600;700&display=swap";
    }
}