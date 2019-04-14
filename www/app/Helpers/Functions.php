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

if (!function_exists('trimData')) {
    function trimData($data)
    {
        if ($data === null)
            return null;

        if (is_array($data)) {
            return array_map('trimData', $data);
        } else return trim(cleaner($data));
    }
}

if (!function_exists('deleteLongSpace')) {
    function deleteLongSpace($row = FALSE)
    {
        if ($row) {
            return preg_replace('/ {2,}/', ' ', $row);
        }
        return $row;
    }
}

if (!function_exists('cleaner')) {
    function cleaner($row)
    {
        return deleteLongSpace($row);
    }
}