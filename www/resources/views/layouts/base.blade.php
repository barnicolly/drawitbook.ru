<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="yandex-verification" content="e78a61097fbbb899"/>
    <meta name="google-site-verification" content="44qvqCqXAJ59PJZMKJB4zmk8zDa57Ff1mpau2pNfm3Q"/>
    @include('layouts.partials.base.favicon_pack')
    <title>{!! MetaTag::get('title') !!}</title>
    <link rel="stylesheet" href="{{ getUrlFromManifest('vendors.css') }}">
    <link rel="stylesheet" href="{{ getUrlFromManifest('app.css') }}">
    @stack('links')
    {!! MetaTag::get('keywords') ? MetaTag::tag('keywords') : '' !!}
    {!! MetaTag::get('image') ? MetaTag::tag('image') : '' !!}
    {!! MetaTag::get('robots') ? MetaTag::tag('robots') : '' !!}
    {!! MetaTag::get('description') ? MetaTag::tag('description') : '' !!}
    {!! MetaTag::openGraph() !!}
    {!! MetaTag::twitterCard() !!}
    @stack('styles')
    @if (!isLocal() && config('app.debug') === false)
        @include('layouts.partials.metrics')
    @endif
</head>
<body>
@yield('content')
<script src="{{ getUrlFromManifest('polyfills.js') }}" defer></script>
<script src="{{ getUrlFromManifest('runtime.js') }}" defer></script>
<script src="{{ getUrlFromManifest('vendors.js') }}" defer></script>
<script src="{{ getUrlFromManifest('app.js') }}" defer></script>
@stack('scripts')
</body>
</html>
