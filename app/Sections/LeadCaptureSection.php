<?php

namespace AtlasBuilder\Sections;

defined('ABSPATH') || exit;

class LeadCaptureSection implements SectionType
{
    public function key(): string
    {
        return 'lead_capture';
    }

    public function label(): string
    {
        return 'Formulário de Captura';
    }

    public function fields(): array
    {
        return [
            [
                'name'  => 'heading',
                'label' => 'Título',
                'type'  => 'text',
            ],
            [
                'name'  => 'subtitle',
                'label' => 'Subtítulo',
                'type'  => 'textarea',
            ],
            [
                'name'  => 'button_text',
                'label' => 'Texto do Botão',
                'type'  => 'text',
            ],
            [
                'name'  => 'action_url',
                'label' => 'URL de Destino do Formulário (ex: link de ação do Mailchimp/ActiveCampaign)',
                'type'  => 'text',
            ],
        ];
    }

    public function defaults(): array
    {
        return [
            'heading'     => 'Receba conteúdo exclusivo',
            'subtitle'    => 'Cadastre-se para receber novidades.',
            'button_text' => 'Quero me cadastrar',
            'action_url'  => '',
        ];
    }

    public function render(array $data): string
    {
        $heading = esc_html($data['heading'] ?? '');
        $subtitle = esc_html($data['subtitle'] ?? '');
        $buttonText = esc_html($data['button_text'] ?? '');
        $actionUrl = esc_url($data['action_url'] ?? '');

        $html = '<section class="atlas-section atlas-lead-capture">';
        $html .= '<h2>' . $heading . '</h2>';
        $html .= '<p>' . $subtitle . '</p>';
        $html .= '<form method="post" action="' . $actionUrl . '" class="atlas-lead-form">';
        $html .= '<input type="text" name="name" placeholder="Seu nome" class="atlas-input">';
        $html .= '<input type="email" name="email" placeholder="Seu melhor e-mail" required class="atlas-input">';
        $html .= '<button type="submit" class="atlas-button">' . $buttonText . '</button>';
        $html .= '</form>';
        $html .= '</section>';

        return $html;
    }
}