<?php

use core\WPCustomEndPoints;

class PluginController extends WPCustomEndPoints
{
    public function index(): array
    {
        return [
            'plugins' => [
                [
                    'name' => 'Nexo Hub',
                    'version' => 'v1',
                    'namespace' => 'nexo-hub'
                ]
            ]
        ];
    }
}