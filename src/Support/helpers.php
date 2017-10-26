<?php

if (!function_exists('current_timezone'))
{
    function current_timezone()
    {
        return config('app.timezone');
    }
}