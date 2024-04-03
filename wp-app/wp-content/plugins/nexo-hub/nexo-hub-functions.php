<?php

function nexo_hub_init_defined_standalone(): void
{
    define('NEXO_HUB_MAX_PRIORITY_HOOK', 2147483647);
    define('NEXO_HUB_NAME', 'Nexo Hub');
    define('NEXO_HUB_SLUG', 'nexo-hub');
    define('NEXO_HUB_OPTION_GROUP', 'group-nexo-hub');
    define('NEXO_HUB_VERSION', '1.0.0');
    define('NEXO_HUB_GOD_HANDLER_VERSION', '1.0.1');
    define('NEXO_HUB_PHP_MIN', '7.2');

    define('NEXO_HUB_DIR', __DIR__);
    define('NEXO_HUB_DIR_PLUGIN', plugin_dir_path(__FILE__));
    define('NEXO_HUB_DIR_MAIN_FILE', NEXO_HUB_DIR . '/nexo-hub.php');
    define('NEXO_HUB_DIR_WPU_BACKUP', NEXO_HUB_DIR . '/nh-backup');
    define('NEXO_HUB_DIR_WPU_RESTORE', NEXO_HUB_DIR . '/nh-restore');
    define('NEXO_HUB_DIR_WPU_BACKUP_BOX', NEXO_HUB_DIR_WPU_BACKUP . '/box');
    define('NEXO_HUB_DIR_TEMP_RESTORE', NEXO_HUB_DIR . '/temp-restore');
    define('NEXO_HUB_LANGUAGES', NEXO_HUB_DIR . '/languages/');
    define('NEXO_HUB_DIR_DIST', NEXO_HUB_DIR . '/dist');
    define('NEXO_HUB_SITE_URL', 'https://nexo-hub.com');

    $local = ['localhost', 'localhost:8080'];

    if (in_array($_SERVER['HTTP_HOST'], $local)) {
        define('NEXO_HUB_APP_URL', 'http://localhost/');
        define('NEXO_HUB_API_URL', 'http://localhost/api');
        define('NEXO_HUB_DEBUG', true);

        add_action('admin_menu', 'nexo_hub_menu_admin');
    } else {
        define('NEXO_HUB_APP_URL', 'https://nexo-hub.com/');
        define('NEXO_HUB_API_URL', 'https://api.nexo-hub.com');
        define('NEXO_HUB_DEBUG', false);
    }
}

function nexo_hub_init_defined(): void
{
    if (defined('NEXO_HUB_NAME')) return;

    nexo_hub_init_defined_standalone();

    define('NEXO_HUB_BNAME', plugin_basename(__DIR__ . '/nexo-hub.php'));
    define('NEXO_HUB_DIRURL', plugin_dir_url(__FILE__));

}

function nexo_hub_is_compatible(): bool
{
    return version_compare(PHP_VERSION, NEXO_HUB_PHP_MIN, '>=');
}
