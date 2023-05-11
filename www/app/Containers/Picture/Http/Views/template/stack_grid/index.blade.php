<div class="stack-grid-wrapper form-group">
    <div class="stack-loader-container">
        <div class="stack-loader-wrapper">
            <div class="stack-loader-text">
                {{ __('common.loading') }}
            </div>
            <div class="stack-loader"></div>
        </div>
    </div>
    <div class="stack-grid form-group"
         style="display: none"
         data-page="{{ $page ?? 1 }}"
         itemscope=""
         itemtype="http://schema.org/SiteNavigationElement">
        @include('picture::template.stack_grid.elements')
    </div>
    <?php
    /** @var \App\Ship\Dto\PaginationDto $paginationData */

    ?>
    @if (isset($paginationData))
        @if ($paginationData->left)
            <div class="download-more form-group">
                <button type="button" class="download-more__btn">
                    {!! __('common.arts_left', ['countLeftArtsText' => $leftArtsText]) !!}
                </button>
            </div>
        @endif
    @endif
</div>
