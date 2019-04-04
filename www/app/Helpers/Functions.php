<?php

if (!function_exists('listDir')) {
    function listDir($dir)
    {
        $skip = ['.', '..'];
        $files = scandir($dir);
        foreach ($files as $key => $file) {
            if (in_array($file, $skip) || !is_dir($dir . $file)) {
                unset($files[$key]);
            } else {
                $files[$key] = $file;
            }
        }
        return $files;
    }
}