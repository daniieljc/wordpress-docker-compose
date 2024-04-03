<?php

namespace Service\Plugin;

use Plugin_Upgrader;
use WP_Ajax_Upgrader_Skin;

class Update
{
    public function update($plugin): array
    {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
        require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

        $upgrader = new Plugin_Upgrader();
        $responseUpgradePlugin = $upgrader->upgrade($plugin);

        if (is_wp_error($responseUpgradePlugin)) {
            return [
                'status' => 'error',
                'message' => $responseUpgradePlugin->get_error_message()
            ];
        }

        return [
            'status' => 'success',
            'message' => 'Plugin updated successfully',
            'data' => $responseUpgradePlugin
        ];
    }

    public function bulkUpdate($plugins): array
    {
        require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
        require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';

        $upgrader = new Plugin_Upgrader(new WP_Ajax_Upgrader_Skin());
        $responseUpgradePlugin = $upgrader->bulk_upgrade($plugins);

        $result = array_map(function ($item) {
            return [
                'status' => is_wp_error($item) ? 'error' : 'success',
                'message' => is_wp_error($item) ? $item->get_error_message() : 'Plugin updated successfully',
                'data' => $item
            ];
        }, $responseUpgradePlugin);

        return [
            'status' => 'success',
            'message' => 'Plugins updated successfully',
            'data' => $result
        ];
    }
}