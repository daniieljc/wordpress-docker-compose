<?php

use core\WPCustomEndPoints;

class TestController extends WPCustomEndPoints
{
    public static function index(): string
    {
        return 'TestController@index';
    }
}