<figure itemprop="image" class="shared-image" itemscope itemtype="http://schema.org/ImageObject">
    <?php $alt = '';
    if ($picture->alt) {
        $alt = $picture->alt;
    } ?>
    <div class="img-wrapper">
        @if (isset($activeLink) && $activeLink === true)
            <?php
            $path_parts = pathinfo($picture->path);
            $thumbnailPath = $path_parts['dirname']
                . '/'
                . $path_parts['filename']
                . '_thumb.'
                . $path_parts['extension'];
            ?>
            <a itemprop="url" class="fullscreen-image" href="{{ asset('content/arts/' . $picture->path) }}"
               rel="nofollow"
               data-thumb="{{ asset('content/thumbnails/arts/' . $thumbnailPath) }}"
               data-id="{{ $picture->id }}"
            >
                {{--                //TODO-misha избавиться от стилей в коде;--}}
                <div
                    style="width:100%;height:0; padding-top:{{ $picture->height / $picture->width * 100 }}%;position:relative;">
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
                             style="position:absolute; top:0; left:0; width:100%;height: 100%;"
                             data-title="Art #{{ $picture->id }} | Drawitbook.ru"
                             class="img-responsive lazyload"
                             data-src="{{ asset('content/arts/' . $picture->path) }}"
                             alt="{{ $alt }}">
                    </picture>
                </div>
            </a>
        @else
            <?php $img = b64img('', 6, $picture->width, $picture->height); ?>
            <img class="img-responsive lazyload"
                 data-url="{{ route('art', ['id' => $picture->id]) }}"
                 data-title="Art #{{ $picture->id }} | Drawitbook.ru"
                 itemprop="contentUrl"
                 data-src="{{ asset('content/arts/' . $picture->path) }}"
                 src="data:image/png;base64,{{$img}}"
                 alt="{{ $alt }}">
        @endif
        <div class="rate-footer">
            @include('Open::template.rate', ['pictureId' => $picture->id])
        </div>
        <div class="find-similar">
            <a itemprop="url" href="#" rel="nofollow" title="Найти похожие">
                <svg role="img" width="26" height="26" viewBox="0 0 26 26">
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
