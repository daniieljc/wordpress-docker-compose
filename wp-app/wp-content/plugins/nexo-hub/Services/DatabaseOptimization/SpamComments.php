<?php

namespace Service\DatabaseOptimization;
class SpamComments
{
    const NAME_SERVICE = 'SpamComments';

    public function getTotal(): int
    {
        global $wpdb;
        $total = $wpdb->get_var(
            "SELECT COUNT(comment_ID) FROM $wpdb->comments WHERE comment_approved = 'spam'"
        );
        return (int)$total;
    }

    public function optimize(): array
    {
        global $wpdb;
        $query = $wpdb->get_col(
            "SELECT comment_ID FROM $wpdb->comments WHERE comment_approved = 'spam'"
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