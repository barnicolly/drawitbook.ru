<?php

declare(strict_types=1);

use App\Ship\Services\File\FileService;

if (!function_exists('buildUrl')) {
    function buildUrl(string $path): string
    {
        $uri = preg_replace('#\\/{2,}#', '/', '/build/' . $path);
        return asset($uri);
    }
}
if (!function_exists('getUrlFromManifest')) {
    function getUrlFromManifest(string $path): string
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
        return app(FileService::class)->formArtUrlPath($artRelativePath);
    }
}
if (!function_exists('formArtFsPath')) {
    function formArtFsPath(string $artRelativePath): string
    {
        $artFolder = getArtsFolder();
        return url("{$artFolder}{$artRelativePath}");
    }
}
