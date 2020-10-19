<?php $adPostfix = $page ?? 1; ?>
@foreach($pictures as $index => $picture)
    @if(in_array($index, [5, 12, 18], true))
        <div class="art-container art-container-ad">
            <div class="art-wrapper integration">
                <div class="integration__content">
                    {!! loadAd('integrated-' . $index, $adPostfix, true) !!}
                </div>
                <div class="integration__label">
                    <span class="integration__text float-right">Реклама</span>
                </div>
            </div>

        </div>
    @endif
    <?php $viewData = [
        'picture' => $picture,
        'showAllTags' => $showAllTags ?? false,
        'tagged' => $tagged ?? false,
        'page' => $page ?? 1
    ]; ?>
    @include('Arts::template.stack_grid.art.index', $viewData)
@endforeach
@if ($pictures->count() > 21)
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
