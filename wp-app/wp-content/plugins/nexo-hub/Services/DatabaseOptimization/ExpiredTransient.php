<?php

namespace Service\DatabaseOptimization;

class ExpiredTransient
{
    const NAME_SERVICE = 'ExpiredTransient';

    public function getTotal(): int
    {
        global $wpdb;

        $time = isset($_SERVER['REQUEST_TIME']) ? (int)$_SERVER['REQUEST_TIME'] : time();
        $optionName = $wpdb->esc_like('_transient_') . '%';

        $total = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT COUNT(option_id) FROM $wpdb->options
            WHERE option_name LIKE %s
            AND option_value < %d",
                $optionName,
                $time
            )
        );

        return (int)$total;
    }

    public function optimize(): array
    {
        global $wpdb;

        $time = isset($_SERVER['REQUEST_TIME']) ? (int)$_SERVER['REQUEST_TIME'] : time();
        $optionName = $wpdb->esc_like('_transient_') . '%';

        $query = $wpdb->get_col(
            $wpdb->prepare(
                "SELECT option_name FROM $wpdb->options
            WHERE option_name LIKE %s
            AND option_value < %d",
                $optionName,
                $time
            )
        );

        $data = [
            'total_optimized' => 0,
        ];

        foreach ($query as $transient) {
            $transient = str_replace('_transient_timeout_', '', $transient);
            delete_transient($transient);
            $data['total_optimized']++;
        }

        return $data;
    }

}
