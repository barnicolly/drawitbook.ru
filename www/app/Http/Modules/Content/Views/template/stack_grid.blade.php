<div class="stack-grid-wrapper">
    <div class="stack-loader-container">
        <div class="stack-loader-wrapper">
            <div class="stack-loader-text">
                Загрузка
            </div>
            <div class="stack-loader"></div>
        </div>
    </div>
    <div class="stack-grid" style="display: none" itemscope="" itemtype="http://schema.org/SiteNavigationElement">
        @foreach($pictures as $index => $picture)
            @if(in_array($index, [5, 12, 18], true))
                <div class="art-container">
                    <div class="art-wrapper clearfix">
                        <div class="ad">
                            {!! loadAd('integrated-' . $index) !!}
                        </div>
                        <div>
                            <span class="ad-label float-right">Реклама</span>
                        </div>
                    </div>
                </div>
            @endif
            @include('Content::template.stack_grid_art_container', ['picture' => $picture, 'showAllTags' => $showAllTags ?? false])
        @endforeach
    </div>
</div>