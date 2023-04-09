<figure class="fullscreen-image" itemprop="image" itemscope itemtype="http://schema.org/ImageObject">
    <?php
    $primaryImage = $art['images']['primary'];
    $optimizedImage = $art['images']['optimized'] ?? [];
    $artUrlPath = formArtUrlPath($primaryImage['path']); ?>
    <div>
        <a itemprop="url" class="fullscreen-image__link" href="{{ $artUrlPath }}"
           rel="nofollow"
           data-id="{{ $art['id'] }}">
            <div class="fullscreen-image__inner"
                 style="padding-top:{{ (int) ($primaryImage['height'] / $primaryImage['width'] * 100) }}%;">
                <picture>
                    @if (!empty($optimizedImage))
                        <?php $optimizedImagePath = formArtUrlPath($optimizedImage['path']); ?>
                        <source type="image/webp" data-srcset="{{ $optimizedImagePath }}"/>
                    @endif
                    <source type="{{ $primaryImage['mime_type'] }}"
                            data-srcset="{{ $artUrlPath }}"/>
                    <img width="{{ $primaryImage['width'] }}"
                         height="{{ $primaryImage['height'] }}"
                         data-title="Art #{{ $art['id'] }} | Drawitbook.com"
                         class="img-responsive lazyload fullscreen-image__img"
                         data-src="{{ $artUrlPath }}"
                         alt="{{ $art['alt'] }}">
                </picture>
            </div>
        </a>
        <div class="fullscreen-image__rate">
            @include('picture::template.stack_grid.art.rate', ['artId' => $art['id']])
        </div>
    </div>
    <link itemprop="url" href="{{ $artUrlPath }}">
    <link itemprop="contentUrl" href="{{ $artUrlPath }}">
    <meta itemprop="height" content="{{ $primaryImage['height'] }}px">
    <meta itemprop="width" content="{{ $primaryImage['width'] }}px">
    <meta itemprop="representativeOfPage" content="True">
</figure>
