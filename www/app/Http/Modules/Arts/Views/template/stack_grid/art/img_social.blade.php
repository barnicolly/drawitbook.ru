<figure class="fullscreen-image" itemprop="image" itemscope itemtype="http://schema.org/ImageObject">
    <?php $artUrlPath = formArtUrlPath($art['path']); ?>
    <div>
        <a itemprop="url" class="fullscreen-image__link" href="{{ $artUrlPath }}"
           rel="nofollow"
           data-id="{{ $art['id'] }}">
            <div class="fullscreen-image__inner"
                 style="padding-top:{{ (int) ($art['height'] / $art['width'] * 100) }}%;">
                <picture>
                    <?php $webpSourceRelativePath = formArtWebpFormatRelativePath($art['path']) ?>
                    @if (!empty($webpSourceRelativePath) && checkExistArt($webpSourceRelativePath))
                        <source type="image/webp"
                                data-srcset="<?= formArtUrlPath($webpSourceRelativePath) ?>"/>
                    @endif
                    <source type="{{ getMimeType($art['path']) }}"
                            data-srcset="{{ $artUrlPath }}"/>
                    <img width="{{ $art['width'] }}"
                         height="{{ $art['height'] }}"
                         data-title="Art #{{ $art['id'] }} | Drawitbook.ru"
                         class="img-responsive lazyload fullscreen-image__img"
                         data-src="{{ $artUrlPath }}"
                         alt="{{ $art['alt'] }}">
                </picture>
            </div>
        </a>
        <div class="fullscreen-image__rate">
            @include('Arts::template.stack_grid.art.rate', ['artId' => $art['id']])
        </div>
        <div class="fullscreen-image__find-similar find-similar">
            <a itemprop="url" href="{{ route('search') . '?similar=' . $art['id'] }}" rel="nofollow"
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
    <meta itemprop="height" content="{{ $art['height'] }}px">
    <meta itemprop="width" content="{{ $art['width'] }}px">
    <meta itemprop="representativeOfPage" content="True">
</figure>
