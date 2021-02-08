@extends('layouts.errors')

@section('errors.title')
    <h1>{{ __('pages.500.h1') }}</h1>
@endsection

@section('errors.content')
    <div>
        {{ __('pages.500.subtitle') }}
    </div>
@endsection
