<?php

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

if (!function_exists('set_active')) {
    /**
     * Return "active" if the current route/path matches
     *
     * @param string|array $patterns
     * @param string $class
     * @return string
     */
    function set_active($patterns, $class = 'active')
    {
        foreach ((array) $patterns as $pattern) {
            if (Request::is($pattern . '*') || Route::is($pattern)) {
                return $class;
            }
        }
        return '';
    }
}
