<?php

namespace AtlasBuilder\Sections;

defined('ABSPATH') || exit;

class FaqSection implements SectionType
{
    public function key(): string
    {
        return 'faq';
    }

    public function label(): string
    {
        return 'Perguntas Frequentes (FAQ)';
    }

    public function fields(): array
    {
        return [
            [
                'name'  => 'heading',
                'label' => 'Título da seção',
                'type'  => 'text',
            ],
            [
                'name'  => 'items_raw',
                'label' => 'Perguntas e Respostas (escreva a pergunta na primeira linha, a resposta logo abaixo, e separe cada par com uma linha contendo apenas ---)',
                'type'  => 'textarea',
            ],
        ];
    }

    public function defaults(): array
    {
        return [
            'heading'   => 'Perguntas Frequentes',
            'items_raw' => "Qual é o prazo de entrega?\nVocê recebe o material imediatamente após a compra.\n---\nPosso pedir reembolso?\nSim, você tem garantia de 7 dias.",
        ];
    }

    public function render(array $data): string
    {
        $heading = esc_html($data['heading'] ?? '');
        $itemsRaw = $data['items_raw'] ?? '';

        $blocks = explode('---', $itemsRaw);

        $itemsHtml = '';

        foreach ($blocks as $block) {
            $lines = array_values(array_filter(array_map('trim', explode("\n", trim($block)))));

            if (count($lines) < 2) {
                continue;
            }

            $question = esc_html($lines[0]);
            $answer = esc_html(implode(' ', array_slice($lines, 1)));

            $itemsHtml .= '<div class="atlas-faq-item">';
            $itemsHtml .= '<p class="atlas-faq-question">' . $question . '</p>';
            $itemsHtml .= '<p class="atlas-faq-answer">' . $answer . '</p>';
            $itemsHtml .= '</div>';
        }

        $html = '<section class="atlas-section atlas-faq">';
        $html .= '<h2>' . $heading . '</h2>';
        $html .= $itemsHtml;
        $html .= '</section>';

        return $html;
    }
}