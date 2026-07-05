<?php

namespace AtlasBuilder\Renderer;

defined('ABSPATH') || exit;

class FrontendController
{
    public function __construct(private Renderer $renderer)
    {
    }

    public function register(): void
    {
        add_action('template_redirect', [$this, 'maybeRender']);
    }

    public function maybeRender(): void
    {
        if (!is_singular('atlas_landing')) {
            return;
        }

        $postId = get_queried_object_id();

        echo $this->renderer->render($postId);
        exit;
    }
}