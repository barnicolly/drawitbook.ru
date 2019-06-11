<?php

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Главная', '/', ['icon' => 'fa fa-home']);
});

Breadcrumbs::for('arts.cell', function ($trail) {
    $trail->parent('home');
    $trail->push('Рисунки по клеточкам', '/risunki-po-kletochkam');
});

Breadcrumbs::for('arts.cell.search', function ($trail) {
    $trail->parent('home');
    $trail->push('Рисунки по клеточкам', '/risunki-po-kletochkam/search');
});

Breadcrumbs::for('arts.cell.search.tagged', function ($trail, $tag) {
    $trail->parent('arts.cell.search');
    $trail->push($tag);
});