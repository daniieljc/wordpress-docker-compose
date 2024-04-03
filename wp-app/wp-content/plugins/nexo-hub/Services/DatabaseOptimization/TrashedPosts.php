<?php

namespace Service\DatabaseOptimization;

class TrashedPosts
{
    const NAME_SERVICE = 'TrashedPosts';

    public function getTotal(): int
    {
        global $wpdb;
        $total = $wpdb->get_var(
            "SELECT COUNT(ID) FROM $wpdb->posts WHERE post_status = 'trash'"
        );
        return (int)$total;
    }

    public function optimize(): array
    {
        global $wpdb;
        $query = $wpdb->get_col(
            "SELECT ID FROM $wpdb->posts WHERE post_status = 'trash'"
        );
        $data = [
            'total_optimized' => 0,
        ];
        foreach ($query as $post) {
            wp_delete_post($post, true);
            $data['total_optimized']++;
        }
        return $data;
    }
}