<figure class="fullscreen-image" itemprop="image" itemscope itemtype="http://schema.org/ImageObject">
    <?php $alt = '';
    if ($picture->alt) {
        $alt = $picture->alt;
    } ?>
    <div>
        <?php
        //TODO-misha изолировать получение ссылки к миниатюре;
        $path_parts = pathinfo($picture->path);
        $thumbnailPath = $path_parts['dirname']
            . '/'
            . $path_parts['filename']
            . '_thumb.'
            . $path_parts['extension'];
        ?>
        <a itemprop="url" class="fullscreen-image__link" href="{{ asset('content/arts/' . $picture->path) }}"
           rel="nofollow"
           data-thumb="{{ asset('content/thumbnails/arts/' . $thumbnailPath) }}"
           data-id="{{ $picture->id }}">
            <div class="fullscreen-image__inner"
                 style="padding-top:{{ (int) ($picture->height / $picture->width * 100) }}%;">
                <picture>
                    <?php $fileInfo = pathinfo(public_path('content/arts/') . $picture->path);?>
                    @if (!empty($fileInfo['extension']))
                        <?php $otherSource = 'content/arts/' . str_replace(
                                ('.' . $fileInfo['extension']),
                                '.webp',
                                $picture->path
                            ); ?>
                        @if (file_exists(public_path($otherSource)))
                            <source type="image/webp"
                                    data-srcset="<?= asset($otherSource) ?>"/>
                        @endif
                    @endif
                    <source type="image/jpg" data-srcset="<?= asset('content/arts/' . $picture->path) ?>"/>
                    <img width="{{ $picture->width }}"
                         height="{{ $picture->height }}"
                         data-title="Art #{{ $picture->id }} | Drawitbook.ru"
                         class="img-responsive lazyload fullscreen-image__img"
                         data-src="{{ asset('content/arts/' . $picture->path) }}"
                         alt="{{ $alt }}">
                </picture>
            </div>
        </a>
        <div class="fullscreen-image__rate">
            @include('Arts::template.stack_grid.art.rate', ['pictureId' => $picture->id])
        </div>
        <div class="fullscreen-image__find-similar find-similar">
            <a itemprop="url" href="{{ route('search') . '?similar=' . $picture->id }}" rel="nofollow"
               class="find-similar__btn"
               title="Найти похожие">
                <svg class="find-similar__icon" role="img" width="26" height="26" viewBox="0 0 26 26">
                    <use xlink:href="{{ getUrlFromManifest('icons/sprite.svg') . '#image-similar' }}"></use>
                </svg>
            </a>
        </div>
    </div>
    <link itemprop="url" href="{{ asset('content/arts/' . $picture->path) }}">
    <link itemprop="contentUrl" href="{{ asset('content/arts/' . $picture->path) }}">
    <meta itemprop="height" content="{{ $picture->height }}px">
    <meta itemprop="width" content="{{ $picture->width }}px">
    <meta itemprop="representativeOfPage" content="True">
</figure>
