@extends('layouts.public.layout', ['showSocial' => true])

@section('layout.content')
    <div class="content">
        @yield('layouts.landing.first_block')
    </div>
    <div id="before_stack"></div>

    <div class="form-group content mobile-no-padding">
        {!! loadAd('before_stack') !!}
    </div>
    <div class="content">
        <div class="d-inline">
            {!! __('common.arts_count', ['countArts' => $countRelatedArts]) !!}
        </div>
    </div>
    <div class="content">
        @yield('layouts.landing.content')
    </div>
    <div class="form-group content mobile-no-padding">
        {!! loadAd('after_first_stack') !!}
    </div>
    @hasSection('layouts.landing.seo')
        <div class="form-group content">
            @yield('layouts.landing.seo')
        </div>
    @endif
@endsection
