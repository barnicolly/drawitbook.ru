@foreach($article->pictures as $picture)
    <div class="art-container form-group" >
        <figure >
            <div class="shared-image" style="position: relative">
                <img class="img-fluid " src="{{ asset('arts/' . $picture->path) }}">
                <div class="rate-footer" style=" position: absolute; bottom: 5px; right: 5px">
                    @include('Content::template.rate', ['pictureId' => $picture->id])
                </div>
            </div>

            @if($picture->pivot->caption)
                <figcaption>
                    {{ $picture->pivot->caption }}
                </figcaption>
            @endif
        </figure>
    </div>
@endforeach