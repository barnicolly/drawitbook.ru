@extends('layouts.errors')

@section('errors.title')
    <h1>{{ __('pages.404.h1') }}</h1>
@endsection

@section('errors.content')
    <div>
        <p class="form-group">
            {{ __('pages.404.subtitle', ['url' => $incorrectUrl]) }}
        </p>
        {!! __('pages.404.suggests') !!}
    </div>
@endsection
