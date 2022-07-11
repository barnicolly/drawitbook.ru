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
        return app(\App\Ship\Services\File\FileService::class)->formArtUrlPath($artRelativePath);
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
        return public_path("{$artFolder}{$artRelativePath}");
    }
}

if (!function_exists('formDefaultShareArtUrlPath')) {
    function formDefaultShareArtUrlPath(bool $relative = false): string
    {
        $artFolder = getArtsFolder();
        return $relative
            ? "{$artFolder}d4/11/d4113a118447cb7650a7a7d84b45b153.jpeg"
            : asset("{$artFolder}d4/11/d4113a118447cb7650a7a7d84b45b153.jpeg");
    }
}
