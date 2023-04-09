<?php

Breadcrumbs::for('home', static function ($trail) : void {
    $trail->push(__('breadcrumbs.home'), Router::route('home'));
});

Breadcrumbs::for('breadcrumbs.dynamic', static function ($trail, $breadcrumbs) : void {
    $trail->parent('home');
    foreach ($breadcrumbs as $breadcrumb) {
        $trail->push($breadcrumb->title, $breadcrumb->url);
    }
});
