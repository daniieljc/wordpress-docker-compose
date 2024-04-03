<?php

namespace Service\DatabaseOptimization;

class  Revisions
{
    const NAME_SERVICE = 'Revisions';

    public function getTotal(): int
    {
        global $wpdb;

        $total = $wpdb->get_var(
            "SELECT COUNT(ID) FROM $wpdb->posts WHERE post_type = 'revision'"
        );

        return (int)$total;
    }

    public function optimize(): array
    {
        global $wpdb;

        $query = $wpdb->get_col(
            "SELECT ID FROM $wpdb->posts WHERE post_type = 'revision'"
        );

        $data = [
            'total_optimized' => 0,
        ];

        foreach ($query as $revision) {
            wp_delete_post_revision($revision);
            $data['total_optimized']++;
        }

        return $data;
    }
}