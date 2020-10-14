<div class="stack-grid-wrapper form-group">
    <div class="stack-loader-container">
        <div class="stack-loader-wrapper">
            <div class="stack-loader-text">
                Загрузка
            </div>
            <div class="stack-loader"></div>
        </div>
    </div>
    <div class="stack-grid form-group"
         style="display: none"
         data-page="{{ $page ?? 1 }}"
         itemscope=""
         itemtype="http://schema.org/SiteNavigationElement">
        @foreach($pictures as $index => $picture)
            @if(in_array($index, [5, 12, 18], true))
                <div class="art-container art-container-ad">
                    <div class="art-wrapper integration">
                        <div class="integration__content">
                            {!! loadAd('integrated-' . $index, true) !!}
                        </div>
                        <div class="integration__label">
                            <span class="integration__text float-right">Реклама</span>
                        </div>
                    </div>
                </div>
            @endif
            @include('Open::template.stack_grid_art_container', ['picture' => $picture, 'showAllTags' => $showAllTags ?? false, 'tagged' => $tagged ?? false])
        @endforeach
        @if ($pictures->count() > 21)
            <div class="art-container art-container-ad">
                <div class="art-wrapper integration">
                    <div class="integration__content">
                        {!! loadAd('in_stack_arts_last', true) !!}
                    </div>
                    <div class="integration__label">
                        <span class="integration__text float-right">Реклама</span>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @if (isset($countRelatedPictures, $isLastSlice))
        @if ($countRelatedPictures && !$isLastSlice)
            <div class="download-more form-group">
                <?php $leftPicturesText = pluralForm($countLeftPictures, ['рисунок', 'рисунка', 'рисунков']); ?>
                <button type="button" class="download-more__btn">
                    Показать еще <span class="left-pictures-cnt">{{ $leftPicturesText }}</span>
                </button>
            </div>
        @endif
    @endif
</div>
