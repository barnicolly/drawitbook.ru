<?php

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
if (!function_exists('getArtsFolder')) {
    function getArtsFolder(): string
    {
        return 'content/arts/';
    }
}

if (!function_exists('formArtUrlPath')) {
    function formArtUrlPath(string $artRelativePath): string
    {
        return asset(getArtsFolder() . $artRelativePath);
    }
}

if (!function_exists('checkExistArt')) {
    function checkExistArt(string $artRelativePath): bool
    {
        return file_exists(formArtFsPath($artRelativePath));
    }
}

if (!function_exists('formArtFsPath')) {
    function formArtFsPath(string $artRelativePath): string
    {
        $artFolder = getArtsFolder();
        return public_path("{$artFolder}/{$artRelativePath}");
    }
}

if (!function_exists('formArtWebpFormatRelativePath')) {
    function formArtWebpFormatRelativePath(string $artRelativePath): string
    {
        $artUrlPath = formArtUrlPath($artRelativePath);
        $fileInfo = pathinfo($artUrlPath);
        if (!empty($fileInfo['extension'])) {
            $extension = $fileInfo['extension'];
            return str_ireplace(".{$extension}", '.webp', $artRelativePath);
        }
        return '';
    }
}

if (!function_exists('formDefaultShareArtUrlPath')) {
    function formDefaultShareArtUrlPath(): string
    {
        $artFolder = getArtsFolder();
        return asset("{$artFolder}/d4/11/d4113a118447cb7650a7a7d84b45b153.jpeg");
    }
}

if (!function_exists('getMimeType')) {
    function getMimeType(string $filename): string
    {
        $mimeTypes = [
            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',
        ];

        $array = explode('.', $filename);
        $ext = strtolower(array_pop($array));
        if (array_key_exists($ext, $mimeTypes)) {
            return $mimeTypes[$ext];
        } elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimetype;
        } else {
            return 'application/octet-stream';
        }
    }
}
