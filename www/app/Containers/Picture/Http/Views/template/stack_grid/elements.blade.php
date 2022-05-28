<?php $adPostfix = $page ?? 1;
$showAds = app()->getLocale() === \App\Containers\Translation\Enum\Lang::RU;
?>
@foreach($arts as $art)
    @if(in_array($loop->index, [5, 12, 18], true) && $showAds)
        <div class="art-container art-container-ad">
            <div class="art-wrapper integration">
                <div class="integration__label">
                    <span class="integration__text float-right">
                        {{ __('common.advertisement') }}
                    </span>
                </div>
                <div class="integration__content">
                    {!! loadAd('integrated-' . $loop->index, $adPostfix) !!}
                </div>
            </div>
        </div>
    @endif
    <?php $viewData = [
        'art' => $art,
        'page' => $page ?? 1
    ]; ?>
    @include('picture::template.stack_grid.art.index', $viewData)
@endforeach
@if (count($arts) > 21 && $showAds)
    <div class="art-container art-container-ad">
        <div class="art-wrapper integration">
            <div class="integration__label">
                <span class="integration__text float-right">
                      {{ __('common.advertisement') }}
                </span>
            </div>
            <div class="integration__content">
                {!! loadAd('in_stack_arts_last', $adPostfix) !!}
            </div>
        </div>
    </div>
@endif
