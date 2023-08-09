<?php

declare(strict_types=1);

if (!function_exists('isDevelop')) {
    function isDevelop(): bool
    {
        return config('app.debug');
    }
}
if (!function_exists('loadAd')) {
    function loadAd(string $id, string $idPostFix = ''): string
    {
        $viewData = [
            'id' => $idPostFix ? ($id . '-' . $idPostFix) : $id,
            'isDummy' => isDevelop(),
            'configurationKey' => $id,
        ];
        return view('partials.ad_dummy', $viewData)->render();
    }
}
if (!function_exists('pluralForm')) {
    function pluralForm(int $number, array $after): string
    {
        $cases = [2, 0, 1, 1, 1, 2];
        return $number . ' ' . $after[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min($number % 10, 5)]];
    }
}
if (!function_exists('pluralFormEn')) {
    function pluralFormEn(int $amount, string $singular, string $plural): string
    {
        if ($amount === 1) {
            return $amount . ' ' . $singular;
        }
        return $amount . ' ' . $plural;
    }
}
if (!function_exists('mbUcfirst')) {
    function mbUcfirst(string $string, string $enc = 'UTF-8'): string
    {
        return mb_strtoupper(mb_substr($string, 0, 1, $enc), $enc) .
            mb_substr($string, 1, mb_strlen($string, $enc), $enc);
    }
}
if (!function_exists('frenchQuotes')) {
    function frenchQuotes(string $row): string
    {
        return '«' . $row . '»';
    }
}
