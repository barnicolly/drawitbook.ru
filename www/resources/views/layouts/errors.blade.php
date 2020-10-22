@extends('layouts.public.layout')

@section('layout.content')
    <div class="errors-page">
        <div class="errors-page__img">
            <img class="img-responsive lazyload"
                 data-src="{{ buildUrl('img/page-not-found.png') }}" alt="Произошла ошибка">
        </div>
        <div class="errors-page__content">
            <div class="content">
                <div class="form-group errors-page__title">
                    @yield('errors.title')
                </div>
                @yield('errors.content')
            </div>
        </div>
    </div>
@endsection
