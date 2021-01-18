<?php

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Главная', '/');
});

Breadcrumbs::for('breadcrumbs.dynamic', function ($trail, $breadcrumbs) {
    $trail->parent('home');

    foreach ($breadcrumbs as $breadcrumb) {
        $trail->push($breadcrumb->title, $breadcrumb->url);
    }
});
