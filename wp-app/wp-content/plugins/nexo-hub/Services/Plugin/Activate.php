<?php

namespace Service\Plugin;

class Activate
{
    public function activate($plugin, $silent = false): array
    {
        if (!function_exists('activate_plugin')) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        $activatePluginResult = activate_plugin($plugin, '', $this->isActiveForNetwork($plugin), $silent);

        if (is_wp_error($activatePluginResult)) {
            return [
                'status' => 'error',
                'code' => 'plugin_activation_error',
                'message' => $activatePluginResult->get_error_message()
            ];
        }

        return [
            'status' => 'success',
            'code' => 'plugin_activated',
            'message' => 'Plugin was successfully activated',
            'data' => $activatePluginResult
        ];
    }

    public function isActive($plugin): bool
    {
        if (!function_exists('is_plugin_active')) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        return is_plugin_active($plugin);
    }

    public function isActiveForNetwork($plugin): bool
    {
        return is_plugin_active_for_network($plugin);
    }
}