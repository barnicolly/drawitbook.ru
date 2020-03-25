@extends('Open::template.layout')

@section('layout.content')
    <div class="content">
        @yield('layouts.paginated.first_block')
    </div>
    <div class="form-group content mobile-no-padding">
        {!! loadAd('before_stack') !!}
    </div>
    <div class="content">
        @include('Open::template.partials.paginator', ['hideResultsCount' => false])
    </div>
    <div class="content">
        @yield('layouts.paginated.content')
    </div>
    <div class="content">
        @include('Open::template.partials.paginator', ['hideResultsCount' => true])
    </div>
    <div class="form-group content mobile-no-padding">
        {!! loadAd('after_first_stack') !!}
    </div>
    @if (trim($__env->yieldContent('layouts.paginated.seo')))
        <div class="form-group content">
            @yield('layouts.paginated.seo')
        </div>
    @endif
    <div class="social-fixed-right-wrapper">
        <div class="social-fixed-right">
            @include('Open::template.partials.social_fixed')
        </div>
    </div>
@endsection
