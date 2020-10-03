@foreach ($groups as $categoryName => $group)
    <div class="form-group">
        <div class="category">
            @if ($group['href'])
                <a href="{{ $group['href'] }}" rel="nofollow" itemprop="url">
                    <span itemprop="name">{{ $categoryName }}</span>
                </a>
            @else
                {{ $categoryName }}
            @endif
        </div>
        @foreach ($group['items'] as $categoryItemName => $item)
            <div class="category-item">
                <a href="{{ $item['href'] }}" rel="nofollow" itemprop="url"><span itemprop="name">{{ $categoryItemName }}</span></a>
            </div>
        @endforeach
    </div>
@endforeach
