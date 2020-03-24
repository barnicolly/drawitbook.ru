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
    <link rel="stylesheet" href="{{ buildUrl('app.css') }}">
    @stack('links')
    {!! MetaTag::get('keywords') ? MetaTag::tag('keywords') : '' !!}
    {!! MetaTag::get('image') ? MetaTag::tag('image') : '' !!}
    {!! MetaTag::get('robots') ? MetaTag::tag('robots') : '' !!}
    {!! MetaTag::get('description') ? MetaTag::tag('description') : '' !!}
    {!! MetaTag::openGraph() !!}
    {!! MetaTag::twitterCard() !!}
    @stack('styles')
</head>
<body>
@yield('content')
<script src="{{ buildUrl('polyfills.js') }}" defer></script>
<script src="{{ buildUrl('app.js') }}" defer></script>
@stack('scripts')
</body>
</html>
