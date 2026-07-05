<?php

namespace AtlasBuilder\Core;

defined('ABSPATH') || exit;

use AtlasBuilder\Admin\Menu;
use AtlasBuilder\Landing\PostType;
use AtlasBuilder\Landing\EditScreen;
use AtlasBuilder\Sections\Registry;
use AtlasBuilder\Sections\HeroSection;

class Application
{
    private Registry $sections;

    public function boot(): void
    {
        $this->sections = new Registry();
        $this->sections->register(new HeroSection());

        (new Menu())->register();

        (new PostType())->register();

        (new EditScreen($this->sections))->register();
    }

    public function sections(): Registry
    {
        return $this->sections;
    }
}