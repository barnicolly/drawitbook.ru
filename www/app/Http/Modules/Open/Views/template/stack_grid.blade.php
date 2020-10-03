<div class="stack-grid-wrapper form-group">
    <div class="stack-loader-container">
        <div class="stack-loader-wrapper">
            <div class="stack-loader-text">
                Загрузка
            </div>
            <div class="stack-loader"></div>
        </div>
    </div>
    <div class="stack-grid"
         style="display: none"
         itemscope=""
         itemtype="http://schema.org/SiteNavigationElement">
        @foreach($pictures as $index => $picture)
            @if(in_array($index, [5, 12, 18], true))
                <div class="art-container art-container-ad">
                    <div class="art-wrapper integration">
                        <div class="integration__content">
                            {!! loadAd('integrated-' . $index) !!}
                        </div>
                        <div class="integration__label">
                            <span class="integration__text float-right">Реклама</span>
                        </div>
                    </div>

                </div>
            @endif
            @include('Open::template.stack_grid_art_container', ['picture' => $picture, 'showAllTags' => $showAllTags ?? false, 'tagged' => $tagged ?? false])
        @endforeach
    </div>
</div>
