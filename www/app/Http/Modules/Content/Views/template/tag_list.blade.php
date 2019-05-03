@if ($tags->count())
    @foreach($tags->where('hidden', 0) as $tag)
        <a href="/search?tag[]={{ $tag->name }}"
           title="Поиск по тегу #{{ $tag->name }}"
           class="btn btn-link">#{{ $tag->name }}</a>
    @endforeach
@endif