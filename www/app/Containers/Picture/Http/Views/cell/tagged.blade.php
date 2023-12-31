@extends('picture::template.landing',  ['showSocial' => true])

@section('breadcrumbs')
    @if (!empty($breadcrumbs))
        {{ Breadcrumbs::render('breadcrumbs.dynamic', $breadcrumbs) }}
    @endif
@endsection

@section('layouts.landing.first_block')
    <h1 class="title form-group">
        {{ __('pages.pixel_arts.landing.h1', ['tag' => $tagName]) }}
    </h1>
    <div class="form-group">
        {!! __('pages.pixel_arts.landing.seo_text_begin', ['tag' => $tagName]) !!}
    </div>
@endsection

@section('layouts.landing.content')
    @include('picture::template.stack_grid.index', ['arts' => $arts])
@endsection

@section('layouts.landing.seo')
    {!! __('pages.pixel_arts.landing.seo_text_end', ['tag' => $tagName]) !!}
@endsection
