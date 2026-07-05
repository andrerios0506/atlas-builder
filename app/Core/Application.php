<?php

namespace AtlasBuilder\Core;

defined('ABSPATH') || exit;

use AtlasBuilder\Admin\Menu;
use AtlasBuilder\Landing\PostType;
use AtlasBuilder\Landing\EditScreen;
use AtlasBuilder\Sections\Registry;
use AtlasBuilder\Sections\HeroSection;
use AtlasBuilder\Sections\TextSection;
use AtlasBuilder\Sections\ImageTextSection;
use AtlasBuilder\Sections\TestimonialSection;
use AtlasBuilder\Sections\LeadCaptureSection;
use AtlasBuilder\Renderer\Renderer;
use AtlasBuilder\Renderer\FrontendController;

class Application
{
    private Registry $sections;

    public function boot(): void
    {
        $this->sections = new Registry();
        $this->sections->register(new HeroSection());
        $this->sections->register(new TextSection());
        $this->sections->register(new ImageTextSection());
        $this->sections->register(new TestimonialSection());
        $this->sections->register(new LeadCaptureSection());

        (new Menu())->register();

        (new PostType())->register();

        (new EditScreen($this->sections))->register();

        $renderer = new Renderer($this->sections);
        (new FrontendController($renderer))->register();
    }

    public function sections(): Registry
    {
        return $this->sections;
    }
}