<?php

namespace Service\DatabaseOptimization;

class AutoDrafts
{
    const NAME_SERVICE = 'AutoDrafts';

    public function getTotal(): int
    {
        global $wpdb;

        $query = "SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'auto-draft'";
        $result = $wpdb->get_var($query);

        return (int)$result;
    }

    public function optimize(): array
    {
        global $wpdb;

        $query = "DELETE FROM $wpdb->posts WHERE post_status = 'auto-draft'";
        $result = $wpdb->query($query);

        if (false === $result) {
            return [
                'status' => 'error',
                'code' => 'auto_drafts_not_deleted',
                'message' => 'Auto drafts were not deleted'
            ];
        }

        return [
            'status' => 'success',
            'code' => 'auto_drafts_deleted',
            'message' => 'Auto drafts were successfully deleted',
            'data' => $result
        ];
    }
}