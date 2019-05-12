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

if (!function_exists('isLocal')) {
    function isLocal()
    {
        return !(app()->runningInConsole() || !in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '192.168.1.5'], true));
    }
}

if (!function_exists('loadAd')) {
    function loadAd(string $path)
    {
        if (isLocal()) {
            return view('Content::template.ads.dummy')->render();
        } else {
            return view('Content::template.ads.' . $path)->render();
        }
    }
}

if (!function_exists('pluralForm')) {
    function pluralForm($number, $after)
    {
        $cases = array(2, 0, 1, 1, 1, 2);
        return $number . ' ' . $after[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min($number % 10, 5)]];
    }
}

if (!function_exists('buildUrl')) {
    function buildUrl(string $path)
    {
        return asset($path) . '?' . config('app.version');
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