<?php

/*
 * Plugin Name: Nexo Hub Test
 * Plugin URI: https://nexo-hub.com
 * Description: Nexo Hub is a plugin that allows you to connect your WordPress website to NexoHub.com
 * Version: 1.0.0
 * Author: Nexo Hub
 * Author URI: https://nexo-hub.com
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

add_action('rest_api_init', function () {
    register_rest_route('v1', '/foo', array(
        'methods' => 'GET',
        'callback' => function () {
            $plugins = get_plugins();
            $activePlugins = get_option('active_plugins');
            $networkActivePlugins = get_site_option('active_sitewide_plugins');

            $result = [];

            foreach ($plugins as $pluginPath => $pluginData) {
                $plugin = [
                    'name' => $pluginData['Name'],
                    'description' => $pluginData['Description'],
                    'version' => $pluginData['Version'],
                    'author' => $pluginData['Author'],
                    'networkActive' => isset($networkActivePlugins[$pluginPath]),
                    'active' => in_array($pluginPath, $activePlugins)
                ];

                $result[$pluginPath] = $plugin;
            }

            return $result;
        },
    ));
});
