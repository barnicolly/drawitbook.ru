<div class="shared-image">
    <figure itemprop="image" itemscope itemtype="http://schema.org/ImageObject">
        <?php $alt = '';
        list($width, $height) = getimagesize(public_path('arts/' . $picture->path));
        if (!empty($isArticle) && $picture->pivot->caption) {
            $alt = $picture->pivot->caption;
        } else if ($picture->description) {
            $alt = $picture->description;
        } ?>
        <div class="img-wrapper">
            @if (isset($activeLink) && $activeLink === true)
                <?php $img = b64img('', 6, $width, $height); ?>
                <a itemprop="url" href="{{ route('art', ['id' => $picture->id]) }}" rel="nofollow">
                    <img data-url="{{ route('art', ['id' => $picture->id]) }}"
                         width="{{ $width }}"
                         height="{{ $height }}"
                         data-title="Art #{{ $picture->id }} | Drawitbook.ru" itemprop="contentUrl" class="img-fluid lazy"
                         data-src="{{ asset('arts/' . $picture->path) }}"
                         src="data:image/png;base64,{{$img}}"
                         alt="{{ $alt }}">
                </a>
            @else
                <img class="img-fluid"
                     data-url="{{ route('art', ['id' => $picture->id]) }}"
                     data-title="Art #{{ $picture->id }} | Drawitbook.ru"
                     itemprop="contentUrl"
                     src="{{ asset('arts/' . $picture->path) }}" alt="Рисунки по клеточкам {{ $alt }}">
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
        <meta itemprop="height" content="{{ $height }}px">
        <meta itemprop="width" content="{{ $width }}px">
        <meta itemprop="representativeOfPage" content="True">
    </figure>
</div>