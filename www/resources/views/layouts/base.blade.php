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
    if (!$footer) {
        $footer = view('layouts/footer')->render();
        Cache::put('footer', $footer, config('cache.expiration'));
    } ?>
    {!! $footer !!}
</div>
<script src="{{ buildUrl('build/js/master.min.js') }}" defer></script>
@if (!empty(session('is_admin')))
    <script src="{{ buildUrl('build/js/admin.min.js') }}" defer></script>
@endif
@stack('scripts')
<a id="button">
    <span class="fa fa-arrow-up"></span>
</a>
</body>
</html>