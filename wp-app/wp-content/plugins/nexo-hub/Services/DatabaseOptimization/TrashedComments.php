<?php

namespace Service\DatabaseOptimization;

class TrashedComments
{
    const NAME_SERVICE = 'TrashedComments';

    public function getTotal(): int
    {
        global $wpdb;
        $total = $wpdb->get_var(
            "SELECT COUNT(comment_ID) FROM $wpdb->comments WHERE (comment_approved = 'trash' OR comment_approved = 'post-trashed')"
        );
        return (int)$total;
    }

    public function optimize(): array
    {
        global $wpdb;
        $query = $wpdb->get_col(
            "SELECT comment_ID FROM $wpdb->comments WHERE (comment_approved = 'trash' OR comment_approved = 'post-trashed')"
        );
        $data = [
            'total_optimized' => 0,
        ];
        foreach ($query as $comment) {
            wp_delete_comment($comment, true);
            $data['total_optimized']++;
        }
        return $data;
    }
}