@foreach ($groups as $categoryName => $group)
    <div class="form-group">
        <div class="category dropdown-item">
            @if ($group['href'])
                <a href="{{ $group['href'] }}">{{ $categoryName }}</a>
            @else
                {{ $categoryName }}
            @endif
        </div>
        @foreach ($group['items'] as $categoryItemName => $item)
            <div class="dropdown-item category-item">
                <a href="{{ $item['href'] }}" class="">{{ $categoryItemName }}</a>
            </div>
        @endforeach
    </div>
@endforeach