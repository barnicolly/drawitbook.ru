<?php

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Главная', '/', ['icon' => 'fa fa-home']);
});

Breadcrumbs::for('arts.cell', function ($trail) {
    $trail->parent('home');
    $trail->push('Рисунки по клеточкам', '/risunki-po-kletochkam');
});

Breadcrumbs::for('arts.cell.tagged', function ($trail, $tag) {
    $trail->parent('arts.cell');
    $trail->push($tag);
});