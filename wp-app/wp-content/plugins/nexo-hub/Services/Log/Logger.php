<?php

namespace Services\Log;

class Logger
{
    const NAME_SERVICE = 'Logger';

    protected array $levels = [
        'info',
        'error',
        'critical'
    ];

    public function getLogs(): array
    {
        $logs = [];
        foreach ($this->levels as $level) {
            $logs[$level] = $this->getLog($level);
        }
        return $logs;
    }

    public function saveLog(string $type, string $message): void
    {
        $logs = $this->getLog($type);
        $logs[] = [
            'message' => $message,
            'date' => date('Y-m-d H:i:s')
        ];
        update_option($type, $logs, false);
    }

    protected function getLog(string $type): array
    {
        $content = get_option($type);
        return is_array($content) ? $content : [];
    }
}