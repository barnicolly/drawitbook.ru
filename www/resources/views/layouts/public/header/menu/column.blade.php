<?php $searchRoute = route('arts.cell') . '/'; ?>
@foreach ($parts as $part)
    <div class="form-group">
        <div class="category">
            @if ($part['slug'])
                <a href="{{ $searchRoute . $part['slug'] }}" rel="nofollow" itemprop="url">
                    <span itemprop="name">{{ $part['title'] }}</span>
                </a>
            @else
                {{ $part['title'] }}
            @endif
        </div>
        @foreach ($part['items'] as $item)
            <div class="category-item">
                <a href="{{ $searchRoute. $item['slug'] }}" rel="nofollow" itemprop="url">
                    <span itemprop="name">{{ $item['title'] }}</span>
                </a>
            </div>
        @endforeach
    </div>
@endforeach
