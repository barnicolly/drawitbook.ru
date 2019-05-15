<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="icon" href="/favicon.ico">
    <title>{{ MetaTag::get('title') }}</title>
    @stack('head')
    {!! MetaTag::get('keywords') ? MetaTag::tag('keywords') : '' !!}
    {!! MetaTag::get('image') ? MetaTag::tag('image') : '' !!}
    {!! MetaTag::get('robots') ? MetaTag::tag('robots') : '' !!}
    {!! MetaTag::get('description') ? MetaTag::tag('description') : '' !!}
    {!! MetaTag::openGraph() !!}
    {!! MetaTag::twitterCard() !!}
    <link rel="stylesheet" href="{{ buildUrl('build/css/master.min.css') }}">
    @stack('styles')
</head>
<body>
<div class="container-fluid no-padding">
    @include('layouts/header')
    <div class="container">
        <div class="row">
            <main class="col-12">
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
@stack('scripts')
<a id="button">
    <span class="fa fa-arrow-up"></span>
</a>
</body>
</html>