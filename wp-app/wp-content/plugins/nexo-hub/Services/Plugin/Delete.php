<?php

namespace Service\Plugin;

class Delete
{
    public function delete($plugin)
    {
        $validPlugin = validate_plugin($plugin);
        if (is_wp_error($validPlugin)) {
            return [
                'status' => 'error',
                'code' => 'plugin_deletion_error',
                'message' => $validPlugin->get_error_message()
            ];
        }

        if (is_plugin_active($plugin)) {
            if (is_multisite()) {
                return [
                    'status' => 'error',
                    'code' => 'plugin_active_on_subsite_network',
                    'message' => 'Plugin is active on a subsite network'
                ];
            }
            return [
                'status' => 'error',
                'code' => 'plugin_deletion_error',
                'message' => 'Plugin is active'
            ];
        }

        $deletePluginResult = delete_plugins([$plugin]);

        if (is_wp_error($deletePluginResult)) {
            return [
                'status' => 'error',
                'code' => 'plugin_deletion_error',
                'message' => $deletePluginResult->get_error_message()
            ];
        }

        return [
            'status' => 'success',
            'code' => 'plugin_deleted',
            'message' => 'Plugin was successfully deleted',
            'data' => $deletePluginResult
        ];
    }
}