<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    @include('layouts.partials.base.verification')
    @include('layouts.partials.base.favicon_pack')
    @stack('meta')
    <link rel="stylesheet" href="{{ getUrlFromManifest('vendors.css') }}">
    <link rel="stylesheet" href="{{ getUrlFromManifest('app.css') }}">
    @auth
        <link rel="stylesheet" href="{{ getUrlFromManifest('admin.css') }}">
    @endauth
    @stack('links')
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    @stack('styles')
    @if (!isLocal() && config('app.debug') === false)
        @include('layouts.partials.metrics')
        <script data-ad-client="ca-pub-1368141699085758" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    @endif
</head>
<body>
@yield('content')
<script src="{{ getUrlFromManifest('translations.js') }}" defer></script>
<script src="{{ getUrlFromManifest('polyfills.js') }}" defer></script>
<script src="{{ getUrlFromManifest('runtime.js') }}" defer></script>
<script src="{{ getUrlFromManifest('vendors.js') }}" defer></script>
@auth
    <script src="{{ getUrlFromManifest('admin.js') }}" defer></script>
@endauth
<script src="{{ getUrlFromManifest('app.js') }}" defer></script>
@stack('scripts')
</body>
</html>
