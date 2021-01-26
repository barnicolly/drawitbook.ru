<?php $adPostfix = $page ?? 1; ?>
@foreach($arts as $art)
    @if(in_array($loop->index, [5, 12, 18], true))
        <div class="art-container art-container-ad">
            <div class="art-wrapper integration">
                <div class="integration__content">
                    {!! loadAd('integrated-' . $loop->index, $adPostfix, true) !!}
                </div>
                <div class="integration__label">
                    <span class="integration__text float-right">Реклама</span>
                </div>
            </div>

        </div>
    @endif
    <?php $viewData = [
        'art' => $art,
        'page' => $page ?? 1
    ]; ?>
    @include('Arts::template.stack_grid.art.index', $viewData)
@endforeach
@if (count($arts) > 21)
    <div class="art-container art-container-ad">
        <div class="art-wrapper integration">
            <div class="integration__content">
                {!! loadAd('in_stack_arts_last', $adPostfix, true) !!}
            </div>
            <div class="integration__label">
                <span class="integration__text float-right">Реклама</span>
            </div>
        </div>
    </div>
@endif
