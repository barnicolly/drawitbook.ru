@if (count($breadcrumbs))
    <nav aria-label="breadcrumb" id="breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList">
        <ol class="breadcrumb">
            <meta name="numberOfItems" content="{{ count($breadcrumbs) }}">
            <meta name="itemListOrder" content="Ascending">
            @foreach ($breadcrumbs as $breadcrumb)
                @if ($breadcrumb->url && !$loop->last)
                    <li class="breadcrumb-item" itemscope="" itemprop="itemListElement"
                        itemtype="http://schema.org/ListItem">
                        <a itemprop="item" href="{{ $breadcrumb->url }}" title="{{ $breadcrumb->title }}">
                            @if (isset($breadcrumb->icon))
                                <span class="{{ $breadcrumb->icon }}"></span>
                                <span itemprop="name">{{ $breadcrumb->title }}</span>
                            @else
                                <span itemprop="name">{{ $breadcrumb->title }}</span>
                            @endif
                            <meta itemprop="position" content="{{ ++$loop->index }}">
                        </a>
                    </li>
                @else
                    <li class="breadcrumb-item active" itemscope="" itemprop="itemListElement"
                        itemtype="http://schema.org/ListItem">
                            <div itemprop="item" class="d-inline">
                                <span itemprop="name"> {{ $breadcrumb->title }}</span>
                                <meta itemprop="position" content="{{ ++$loop->index }}">
                            </div>
                    </li>
                @endif

            @endforeach
        </ol>
    </nav>
@endif
