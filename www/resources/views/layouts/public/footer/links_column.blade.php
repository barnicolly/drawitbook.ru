<?php $searchRoute = route('arts.cell') . '/'; ?>
@foreach ($parts as $part)
    <div class="form-group">
        <div class="footer-nav__category">
            @if ($part['slug'])
                <a class="footer-nav__link" href="{{ $searchRoute . $part['slug'] }}" rel="nofollow" itemprop="url">
                    <span itemprop="name">{{ $part['title'] }}</span>
                </a>
            @else
                {{ $part['title'] }}
            @endif
        </div>
        @foreach ($part['items'] as $item)
            <div class="footer-nav__list">
                <a class="footer-nav__link" href="{{ $searchRoute. $item['slug'] }}" rel="nofollow" itemprop="url">
                    <span itemprop="name">{{ $item['title'] }}</span>
                </a>
            </div>
        @endforeach
    </div>
@endforeach
