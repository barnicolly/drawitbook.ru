<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="icon" href="/favicon.ico">
    <title>{{ MetaTag::get('title') }}</title>
    {!! MetaTag::tag('description') !!}
    {!! MetaTag::tag('image') !!}
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
    <?php $footer = Cache::store('file')->get('footer');
    if (!$footer) {
        $footer = view('layouts/footer')->render();
        Cache::store('file')->put('footer', $footer, config('cache.expiration'));
    } ?>
    {!! $footer !!}
</div>
<script src="{{ buildUrl('build/js/master.min.js') }}" defer></script>
@stack('scripts')
</body>
</html>