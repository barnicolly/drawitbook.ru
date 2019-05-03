<div class="shared-image">
    <figure>
        <div class="img-wrapper">
            @if (isset($activeLink) && $activeLink === true)
                <a href="{{ route('art', ['id' => $picture->id]) }}">
                    <img class="img-fluid " src="{{ asset('arts/' . $picture->path) }}">
                </a>
            @else
                <img class="img-fluid "
                     src="{{ asset('arts/' . $picture->path) }}">
            @endif
            <div class="rate-footer">
                @include('Content::template.rate', ['pictureId' => $picture->id])
            </div>
        </div>
        @if (!empty($isArticle))
            @if($picture->pivot->caption)
                <figcaption class="img-caption">
                    {{ $picture->pivot->caption }}
                </figcaption>
            @endif
        @else
            @if($picture->description)
                <figcaption class="img-caption">
                    {{ $picture->description }}
                </figcaption>
            @endif
        @endif
    </figure>
</div>