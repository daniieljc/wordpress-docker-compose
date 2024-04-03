<?php

namespace Service\Plugin;

class Install
{
    public function install($plugin, $overwrite = true): array
    {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

        $skin = new \WP_Ajax_Upgrader_Skin();
        $upgrader = new \Plugin_Upgrader($skin);

        add_filter('upgrader_package_options', function ($options) use ($overwrite) {
            $options['hook_extra']['overwrite'] = $overwrite;
            return $options;
        });

        $resultInstallPlugin = $upgrader->install($plugin);

        if (is_wp_error($resultInstallPlugin)) {
            return [
                'status' => 'error',
                'code' => 'plugin_not_installed',
                'message' => is_wp_error($resultInstallPlugin) ? $resultInstallPlugin->get_error_message() : '',
                'data' => $plugin
            ];
        }

        return [
            'status' => 'success',
            'code' => 'plugin_installed',
            'message' => 'Plugin installed',
            'data' => $plugin
        ];
    }
}