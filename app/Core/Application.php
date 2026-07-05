<?php

namespace AtlasBuilder\Core;

defined('ABSPATH') || exit;

use AtlasBuilder\Admin\Menu;
use AtlasBuilder\Landing\PostType;
use AtlasBuilder\Landing\EditScreen;

class Application
{
    public function boot(): void
    {
        (new Menu())->register();

        (new PostType())->register();

        (new EditScreen())->register();
    }
}