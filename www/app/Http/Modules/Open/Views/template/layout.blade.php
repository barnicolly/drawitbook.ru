@extends('layouts.public.layout')

@section('layout.body')
    <div class="container">
        <div class="form-group content">
            @yield('breadcrumbs')
        </div>
        @yield('layout.content')
    </div>
@endsection
