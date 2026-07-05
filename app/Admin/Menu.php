<?php

namespace AtlasBuilder\Admin;

defined('ABSPATH') || exit;

class Menu
{
    public function register(): void
    {
        add_action('admin_menu', [$this, 'addMenu']);
    }

    public function addMenu(): void
    {
        add_menu_page(
            'Atlas Builder',
            'Atlas Builder',
            'manage_options',
            'atlas-builder',
            [$this, 'renderPage'],
            'dashicons-layout',
            30
        );
    }

    public function renderPage(): void
    {
        ?>
        <div class="wrap">
            <h1>Atlas Builder</h1>
            <p>Bem-vindo ao Atlas Builder.</p>
            <p>Versão 0.1.0-alpha</p>
        </div>
        <?php
    }
}