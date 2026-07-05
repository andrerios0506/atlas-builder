<?php
/**
 * Plugin Name: Atlas Builder
 * Description: Professional Landing Page Builder for WordPress.
 * Version: 0.1.0-alpha
 * Author: Andre Rios
 * Requires at least: 6.5
 * Requires PHP: 8.1
 * Text Domain: atlas-builder
 */

defined('ABSPATH') || exit;

spl_autoload_register(function ($class) {

    $prefix = 'AtlasBuilder\\';

    if (strpos($class, $prefix) !== 0) {
        return;
    }

    $relative = substr($class, strlen($prefix));

    $file = __DIR__ . '/app/' . str_replace('\\', '/', $relative) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

add_action('plugins_loaded', function () {

    $app = new AtlasBuilder\Core\Application();
    $app->boot();

});