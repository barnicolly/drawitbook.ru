@if ($tags->count())
    @foreach($tags->where('hidden', 0) as $tag)
    {{--@foreach($tags as $tag)--}}
        <a href="/search?tag={{ $tag->name }}" class="btn btn-link">#{{ $tag->name }}</a>
    @endforeach
@endif