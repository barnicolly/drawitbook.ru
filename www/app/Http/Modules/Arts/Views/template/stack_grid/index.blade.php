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
    @if (isset($countRelatedArts, $isLastSlice, $countLeftArts))
        @if ($countRelatedArts && !$isLastSlice)
            <div class="download-more form-group">
                <?php $leftArtsText = pluralForm($countLeftArts, ['рисунок', 'рисунка', 'рисунков']); ?>
                <button type="button" class="download-more__btn">
                    Показать еще (осталось <span class="left-pictures-cnt">{{ $leftArtsText }}</span>)
                </button>
            </div>
        @endif
    @endif
</div>
