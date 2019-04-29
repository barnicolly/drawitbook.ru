<div class="stack-grid">
    @foreach($pictures as $index => $picture)
        @if(in_array($index, [5, 12]))
            <div class="art-container">
                <div class="art-wrapper clearfix">
                    {!! loadAd('integrated-' . $index) !!}
                    <div>
                        <span class="ad-label float-right">Реклама</span>
                    </div>
                </div>
            </div>
        @endif

        <div class="art-container">
            <div class="art-wrapper">
                <figure>
                    <a href="{{ route('art', ['id' => $picture->id]) }}">
                        <img class="img-fluid" src="{{ asset('arts/' . $picture->path) }}">
                    </a>
                    <div class="rate-footer">
                        @include('Content::template.rate', ['pictureId' => $picture->id])
                    </div>
                    @if($picture->description)
                        <figcaption>
                            {{ $picture->description }}
                        </figcaption>
                    @endif
                </figure>
                @guest
                @else
                    <span>
                        {{ $picture->id }}
                    </span>
                @endif
                @if ($picture->tags->count())
                    @include('Content::template.tag_list', ['tags' => $picture->tags])
                @endif
            </div>
        </div>
    @endforeach
</div>