<div class="shared-image">
    <figure itemprop="image" itemscope itemtype="http://schema.org/ImageObject">
        <?php $alt = '';
        if (!empty($isArticle) && $picture->pivot->caption) {
            $alt = $picture->pivot->caption;
        } else if ($picture->description) {
            $alt = $picture->description;
        } ?>
        <div class="img-wrapper">
<!--            --><?php //$img = b64img('', 6, $picture->width, $picture->height); ?>
            @if (isset($activeLink) && $activeLink === true)
                <a itemprop="url" href="{{ route('art', ['id' => $picture->id]) }}" rel="nofollow">
                    <img data-url="{{ route('art', ['id' => $picture->id]) }}"
                         width="{{ $picture->width }}"
                         height="{{ $picture->height }}"
{{--                         style="height: {{ $picture->height }}; width: auto"--}}
                         data-title="Art #{{ $picture->id }} | Drawitbook.ru" itemprop="contentUrl" class="img-fluid lazy not-loaded"
                         data-src="{{ asset('arts/' . $picture->path) }}"
{{--                         src="data:image/png;base64,{{$img}}"--}}
                         alt="{{ $alt }}">
                </a>
            @else
                <img class="img-fluid lazy not-loaded"
                     data-url="{{ route('art', ['id' => $picture->id]) }}"
                     data-title="Art #{{ $picture->id }} | Drawitbook.ru"
                     itemprop="contentUrl"
                     data-src="{{ asset('arts/' . $picture->path) }}"
                     src="data:image/png;base64,{{$img}}"
                     alt="Рисунки по клеточкам {{ $alt }}">
            @endif
            <div class="rate-footer">
                @include('Open::template.rate', ['pictureId' => $picture->id])
            </div>
        </div>
        @if (!empty($alt))
            <figcaption class="img-caption" itemprop="caption">
                {{ $alt }}
            </figcaption>
        @endif
        <link itemprop="url" href="{{ asset('arts/' . $picture->path) }}">
        <meta itemprop="height" content="{{ $picture->height }}px">
        <meta itemprop="width" content="{{ $picture->width }}px">
        <meta itemprop="representativeOfPage" content="True">
    </figure>
</div>