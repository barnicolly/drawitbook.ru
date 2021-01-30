@foreach ($parts as $part)
    <div class="form-group">
        <div class="footer-nav__category">
            @if ($part['parent']['link'])
                <a class="footer-nav__link" href="{{ $part['parent']['link'] }}" rel="nofollow" itemprop="url">
                    <span itemprop="name">{{ $part['parent']['title'] }}</span>
                </a>
            @else
                {{ $part['parent']['title'] }}
            @endif
        </div>
        @foreach ($part['items'] as $item)
            <div class="footer-nav__list">
                <a class="footer-nav__link" href="{{ $item['link'] }}" rel="nofollow" itemprop="url">
                    <span itemprop="name">{{ $item['title'] }}</span>
                </a>
            </div>
        @endforeach
    </div>
@endforeach
