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
    function loadAd(string $id)
    {
        if (isLocal()) {
            return view('Open::template.ads.dummy', ['id' => $id])->render();
        } else {
            return '<div id="' . $id . '"></div>';
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
        $uri = preg_replace("/\/{2,}/", '/', '/build/' . $path);
        return asset($uri);
    }
}

if (!function_exists('getUrlFromManifest')) {
    function getUrlFromManifest(string $path)
    {
        $files = config('app.manifest');
        return $files[$path] ?? '';
    }
}

if (!function_exists('mbUcfirst')) {
    function mbUcfirst($string, $enc = 'UTF-8')
    {
        return mb_strtoupper(mb_substr($string, 0, 1, $enc), $enc) .
            mb_substr($string, 1, mb_strlen($string, $enc), $enc);
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
if (!function_exists('b64img')) {
    function b64img($str, $fs = 10, $w = 250, $h = 200, $b = array('r' => 255, 'g' => 255, 'b' => 255), $t = array('r' => 0, 'g' => 0, 'b' => 0))
    {
        $tmp = tempnam(sys_get_temp_dir(), 'img');

//        $image = imagecreatetruecolor($w, $h);
//        imagesavealpha($image, true);
//        $color = imagecolorallocatealpha($image, 0, 0, 0, 127);
//        imagefill($image, 0, 0, $color);
//
//        imagepng($image, $tmp, 9);
//        imagedestroy($image);

        $image = imagecreatetruecolor( $w, $h );
        imagesavealpha( $image, true );
        $color = imagecolorallocatealpha($image, 0, 0, 0, 127);
        imagefill($image, 0, 0, $color);

        // Ouput
        imagepng( $image , $tmp);
        imagedestroy( $image );

        $data = base64_encode(file_get_contents($tmp));
        @unlink($tmp);
        return $data;
    }
}

if (!function_exists('frenchQuotes')) {
    function frenchQuotes(string $row)
    {
        return '«‎' . $row . '»';
    }
}
