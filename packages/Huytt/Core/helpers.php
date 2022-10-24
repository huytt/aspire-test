<?php

if (! function_exists('core')) {
    /**
     * Core helper.
     *
     * @return \Huytt\Core\Core
     */
    function core()
    {
        return app()->make(\Huytt\Core\Core::class);
    }
}
