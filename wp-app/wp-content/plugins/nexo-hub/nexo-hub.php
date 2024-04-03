<?php

/*
 * Plugin Name: Nexo Hub
 * Plugin URI: https://nexo-hub.com
 * Description: Nexo Hub is a plugin that allows you to connect your WordPress website to NexoHub.com
 * Version: 1.0.0
 * Author: Nexo Hub
 * Author URI: https://nexo-hub.com
 */

use core\Route;

require_once __DIR__ . '/nexo-hub-functions.php';

nexo_hub_load_plugin();

require __DIR__ . '/Core/Route.php';

$wpendpoints['config'] = require __DIR__ . '/config/config.php';

spl_autoload_register(function ($class) {
    $classFile = __DIR__ . "/Controllers/{$class}.php";
    if (file_exists($classFile)) {
        require_once $classFile;
        return true;
    }
    return false;
});

function wp_custom_endpoints(): Route
{
    return Route::load(__DIR__ . '/config/routes.php')->dispatch();
}

add_action('rest_api_init', 'wp_custom_endpoints');

function nexo_hub_load_plugin(): void
{
    try {
        nexo_hub_init_defined();

        if (!nexo_hub_is_compatible()) {
            throw new Exception('Nexo Hub requires PHP version ' . NEXO_HUB_PHP_MIN . ' or greater.');
        }

        add_action('rest_api_init', function () {

        });
    } catch (Exception $e) {
        echo 'Nexo Hub failed to load: ' . $e->getMessage();
    }
}

function getPlugins(): WP_REST_Response
{
    $plugins = get_plugins();
    return new WP_REST_Response($plugins, 200);
}

function nexo_hub_menu_admin(): void
{
    add_menu_page(
        NEXO_HUB_NAME,
        NEXO_HUB_NAME,
        'manage_options',
        NEXO_HUB_DIR_PLUGIN . 'index.php',
        '',
        'dashicons-admin-generic',
    );
}

