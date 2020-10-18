<?php $adPostfix = $page ?? 1; ?>
@foreach($pictures as $index => $picture)
    <?php $viewData = [
        'picture' => $picture,
        'showAllTags' => $showAllTags ?? false,
        'tagged' => $tagged ?? false,
        'page' => $page ?? 1
    ]; ?>
    @include('Arts::template.stack_grid.art.index', $viewData)
@endforeach
