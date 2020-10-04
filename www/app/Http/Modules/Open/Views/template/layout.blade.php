@extends('layouts.public.layout')

@section('layout.body')
    <div class="container">
        <div class="fixed-shared-block-wrapper">
            <div class="form-group content">
                @yield('breadcrumbs')
            </div>
            @yield('layout.content')
            <div class="fixed-shared-block">
                <div class="fixed-shared-block__inner"></div>
            </div>
        </div>
    </div>
@endsection
