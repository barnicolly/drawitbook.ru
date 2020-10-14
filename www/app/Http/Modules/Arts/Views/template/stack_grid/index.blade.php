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
            @include('Arts::template.stack_grid.elements')
    </div>
    @if (isset($countRelatedPictures, $isLastSlice, $countLeftPictures))
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
