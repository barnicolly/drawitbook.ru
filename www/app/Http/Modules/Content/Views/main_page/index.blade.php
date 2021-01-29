@extends('layouts.public.layout', ['hideSocial' => true])

@section('layout.content')
    <div class="container">
        <div class="index-page">
            <div class="index-page__content content">
                <h1 class="form-group">
                    Drawitbook.com
                </h1>
                {!! __('pages.main.hello') !!}
                <div id="tag-list">
                    <div id="tagContainer"></div>
                </div>
            </div>
            <div class="index-page__img">
                <img class="img-responsive lazyload" data-src="{{ buildUrl('img/promo.png') }}" alt="Drawitbook.com">
            </div>
        </div>
    </div>
@endsection
