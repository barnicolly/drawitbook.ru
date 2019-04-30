@foreach($article->pictures as $picture)
    <figure>
        <img class="img-fluid" src="{{ asset('arts/' . $picture->path) }}">
        <div class="rate-footer">
            @include('Content::template.rate', ['pictureId' => $picture->id])
        </div>
        @if($picture->pivot->caption)
            <figcaption>
                {{ $picture->pivot->caption }}
            </figcaption>
        @endif
    </figure>
@endforeach