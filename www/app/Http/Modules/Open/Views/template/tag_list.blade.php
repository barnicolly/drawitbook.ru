@if ($tags->count())
    <div class="tag-list">
        @if ($showAllTags)
            @foreach($tags as $tag)
                @if (!empty($tagged))
                    <a href="{{$tagged . '/' . $tag->seo }}"
                       rel="nofollow"
                       itemprop="url"
                       title="Поиск по тегу #{{ $tag->name }}"
                       class="btn btn-link tag">#{{ $tag->name }}</a>
                @else
                    <a href="/search?tag[]={{ $tag->name }}"
                       rel="nofollow"
                       itemprop="url"
                       title="Поиск по тегу #{{ $tag->name }}"
                       class="btn btn-link tag">#{{ $tag->name }}</a>
                @endif

            @endforeach
        @else
            @foreach($tags->where('hidden', 0) as $tag)
                @if (!empty($tagged))
                    <a href="{{$tagged . '/' . $tag->seo }}"
                       rel="nofollow"
                       itemprop="url"
                       title="Поиск по тегу #{{ $tag->name }}"
                       class="btn btn-link tag">#{{ $tag->name }}</a>
                @else
                    <a href="/search?tag[]={{ $tag->name }}"
                       rel="nofollow"
                       itemprop="url"
                       title="Поиск по тегу #{{ $tag->name }}"
                       class="btn btn-link tag">#{{ $tag->name }}</a>
                @endif
            @endforeach
        @endif
    </div>
@endif