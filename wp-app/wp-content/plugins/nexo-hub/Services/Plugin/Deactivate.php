<?php

namespace Service\Plugin;

class Deactivate
{
    public function deactivate($plugin, $silent = true): array
    {
        if (!function_exists('deactivate_plugins')) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        deactivate_plugins($plugin, $silent, is_plugin_active_for_network($plugin));

        return [
            'status' => 'success',
            'code' => 'plugin_desactivated',
            'message' => 'Plugin desactivated',
            'data' => $plugin
        ];
    }
}