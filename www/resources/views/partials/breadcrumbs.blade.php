@if (count($breadcrumbs))
    <nav aria-label="breadcrumb" id="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
        <ol class="breadcrumb">
            <meta name="numberOfItems" content="{{ count($breadcrumbs) }}">
            <meta name="itemListOrder" content="Ascending">
            @foreach ($breadcrumbs as $breadcrumb)
                @if ($breadcrumb->url && !$loop->last)
                    <li class="breadcrumb-item" itemprop="itemListElement" itemscope
                        itemtype="https://schema.org/ListItem">
                        <a itemprop="item" href="{{ $breadcrumb->url }}">
                            @if (isset($breadcrumb->icon))
                                <span class="{{ $breadcrumb->icon }}"></span>
                                <span itemprop="name">{{ $breadcrumb->title }}</span>
                            @else
                                <span itemprop="name">{{ $breadcrumb->title }}</span>
                            @endif
                        </a>
                        <meta itemprop="position" content="{{ ++$loop->index }}"/>
                    </li>
                @else
                    <li class="breadcrumb-item active" itemscope="" itemprop="itemListElement"
                        itemtype="http://schema.org/ListItem">
                        <span itemprop="name"> {{ $breadcrumb->title }}</span>
                        <meta itemprop="position" content="{{ ++$loop->index }}">
                    </li>
                @endif
            @endforeach
        </ol>
    </nav>
@endif
