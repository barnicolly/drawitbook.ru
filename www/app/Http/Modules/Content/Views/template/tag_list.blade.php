@if ($tags->count())
    <div class="tag-list">
        @if ($showAllTags)
            @foreach($tags as $tag)
                <a href="/search?tag[]={{ $tag->name }}"
                   title="Поиск по тегу #{{ $tag->name }}"
                   class="btn btn-link tag">#{{ $tag->name }}</a>
            @endforeach
        @else
            @foreach($tags->where('hidden', 0) as $tag)
                <a href="/search?tag[]={{ $tag->name }}"
                   title="Поиск по тегу #{{ $tag->name }}"
                   class="btn btn-link tag">#{{ $tag->name }}</a>
            @endforeach
        @endif
    </div>
@endif