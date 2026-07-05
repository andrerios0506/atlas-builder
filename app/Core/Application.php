<?php

namespace AtlasBuilder\Core;

defined('ABSPATH') || exit;

use AtlasBuilder\Admin\Menu;
use AtlasBuilder\Landing\PostType;

class Application
{
    public function boot(): void
    {
        (new Menu())->register();

        (new PostType())->register();
    }
}