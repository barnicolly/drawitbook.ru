<div class="row">
    <div class="col-12 col-md-1 social-fixed-sidebar order-1">
        <?php $socialFixed = Cache::remember('social_fixed', config('cache.expiration'), function () {
            return view('Content::art.social_fixed')->render();
        }); ?>
        {!! $socialFixed !!}
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
        <div>
            {!! loadAd('after_article') !!}
        </div>
    </article>
</div>