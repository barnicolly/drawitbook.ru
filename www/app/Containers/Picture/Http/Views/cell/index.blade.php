@extends('layouts.public.layout',  ['showSocial' => true])

@section('breadcrumbs')
    @if (!empty($breadcrumbs))
        {{ Breadcrumbs::render('breadcrumbs.dynamic', $breadcrumbs) }}
    @endif
@endsection

@section('layout.content')
    <div class="content">
        <h1 class="title form-group">
            {{ __('pages.pixel_arts.index.h1') }}
        </h1>
        <div class="form-group">
            {!! __('pages.pixel_arts.index.seo_text') !!}
        </div>
    </div>
    <div class="form-group mobile-no-padding content">
        {!! loadAd('before_stack') !!}
    </div>
    <div class="content">
        @include('picture::template.stack_grid.index', ['arts' => $arts])
    </div>
    <div id="layout-floor"></div>
    <div class="form-group mobile-no-padding content">
        {!! loadAd('after_first_stack') !!}
    </div>
@endsection
