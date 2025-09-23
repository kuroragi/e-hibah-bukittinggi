<?php

if (! function_exists('activity_log')) {
    /**
     * Shortcut ke activity logger
     * activity_log(string $action, $description = [], $user = null, $level = 'info', array $meta = [])
     */
    function activity_log(string $event, $description = [], string $level = 'info')
    {
        return app('activitylog')->log($event, $description, $level);
    }
}