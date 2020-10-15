<figure class="fullscreen-image" itemprop="image" itemscope itemtype="http://schema.org/ImageObject">
    <?php $alt = '';
    if ($picture->alt) {
        $alt = $picture->alt;
    }
    $artUrlPath = formArtUrlPath($picture->path);
    ?>
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
        <a itemprop="url" class="fullscreen-image__link" href="{{ $artUrlPath }}"
           rel="nofollow"
           data-thumb="{{ formArtThumbnailUrlPath($thumbnailPath) }}"
           data-id="{{ $picture->id }}">
            <div class="fullscreen-image__inner"
                 style="padding-top:{{ (int) ($picture->height / $picture->width * 100) }}%;">
                <picture>
                    <?php $webpSourceRelativePath = formArtWebpFormatRelativePath($picture->path); ?>
                    @if (!empty($webpSourceRelativePath) && checkExistArt($webpSourceRelativePath))
                        <source type="image/webp"
                                data-srcset="<?= formArtUrlPath($webpSourceRelativePath) ?>"/>
                    @endif
                    {{--                        //TODO-misha source неверный;--}}
                    <source type="image/jpg" data-srcset="{{ $artUrlPath }}"/>
                    <img width="{{ $picture->width }}"
                         height="{{ $picture->height }}"
                         data-title="Art #{{ $picture->id }} | Drawitbook.ru"
                         class="img-responsive lazyload fullscreen-image__img"
                         data-src="{{ $artUrlPath }}"
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
    <link itemprop="url" href="{{ $artUrlPath }}">
    <link itemprop="contentUrl" href="{{ $artUrlPath }}">
    <meta itemprop="height" content="{{ $picture->height }}px">
    <meta itemprop="width" content="{{ $picture->width }}px">
    <meta itemprop="representativeOfPage" content="True">
</figure>
