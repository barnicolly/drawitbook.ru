@extends('layouts.base')

@push('head')
    <link rel="canonical" href="{{ route('showArticle', ['url' => $article->link]) }}">
@endpush

@section('content')
    <div class="row clearfix">
        <div class="col-md-8">
            <div class="row">
                <div class="col-12 col-md-1 social-fixed-sidebar order-1">
                    @include('Content::art.social_fixed')
                </div>
                <article class="col-12 col-md-11 order-md-1 article" itemscope="" itemtype="http://schema.org/Article">
                    <h1 class="title form-group" itemprop="headline">
                        {{ $article->title }}
                    </h1>
                    <meta itemprop="author" content="admin">
                    <meta itemprop="datePublished" content="{{ $article->created_at }}">
                    <meta itemprop="dateModified" content="{{ $article->updated_at }}">
                    <div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                        <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
                            <?php list($width, $height) = getimagesize(public_path('img/logo.jpg')); ?>
                            <link itemprop="contentUrl" href="{{ asset('img/logo.jpg') }}">
                            <link itemprop="url" href="{{ asset('img/logo.jpg') }}">
                            <meta itemprop="width" content="{{ $width }}px">
                            <meta itemprop="height" content="{{ $height }}px">
                        </div>
                        <meta itemprop="name" content="drawitbook.ru">
                        <meta itemprop="address" content="EnjoyArt">
                        <meta itemprop="telephone" content="56663">
                    </div>
                    <div itemprop="articleBody">
                        {!! $article->template !!}
                    </div>
                </article>
            </div>
        </div>
        <div class="col-md-4 sidebar d-none d-md-block">
            <div class="row">
                <div class="col-12">
                    {!! loadAd('sidebar') !!}
                </div>
            </div>
        </div>
    </div>
@endsection