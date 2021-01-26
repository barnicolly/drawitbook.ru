<div class="tag-list">
    @foreach($tags as $tag)
        <a href="{{ $tag['link'] }}"
           rel="nofollow"
           itemprop="url"
           title="{{ $tag['link_title'] }}"
           class="btn btn-link tag">#{{ $tag['name'] }}</a>
    @endforeach
</div>
