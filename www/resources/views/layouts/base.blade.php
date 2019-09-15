<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="yandex-verification" content="e78a61097fbbb899"/>
    <meta name="google-site-verification" content="44qvqCqXAJ59PJZMKJB4zmk8zDa57Ff1mpau2pNfm3Q"/>
    <link rel="icon" href="/favicon.ico">

    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <title>{!! MetaTag::get('title') !!}</title>
    @stack('head')
    @stack('links')
    {!! MetaTag::get('keywords') ? MetaTag::tag('keywords') : '' !!}
    {!! MetaTag::get('image') ? MetaTag::tag('image') : '' !!}
    {!! MetaTag::get('robots') ? MetaTag::tag('robots') : '' !!}
    {!! MetaTag::get('description') ? MetaTag::tag('description') : '' !!}
    {!! MetaTag::openGraph() !!}
    {!! MetaTag::twitterCard() !!}
    <script src="{{ buildUrl('build/js/loader.min.js') }}" defer></script>
    <link rel="stylesheet" href="{{ buildUrl('build/css/master.min.css') }}">
    @if (!empty(session('is_admin')))
        <link rel="stylesheet" href="{{ buildUrl('build/css/admin.min.css') }}">
    @endif
    @if (!isLocal() && config('app.debug') === false && empty(session('is_admin')))
        @include('layouts/metrics')
    @endif
    @stack('styles')
</head>
<body>
<div class="container-fluid no-padding">
    @include('layouts/header')
    <div class="container" id="main-container">
        <div class="row">
            <main class="col-12">
                @yield('breadcrumbs')
                @yield('content')
            </main>
        </div>
    </div>
    <?php $footer = Cache::get('footer');
    if (!$footer || isLocal()) {
        $footer = view('layouts/footer')->render();
        Cache::put('footer', $footer, config('cache.expiration'));
    } ?>
    {!! $footer !!}
</div>
<script src="{{ buildUrl('build/js/master.min.js') }}" defer></script>
<script src="{{ asset('build/js/lazysizes.min.js') }}" async></script>
@if (!empty(session('is_admin')))
    <script src="{{ buildUrl('build/js/admin.min.js') }}" defer></script>
@endif
@stack('scripts')
<a id="button">
    <span class="fa fa-arrow-up"></span>
</a>
</body>
</html>