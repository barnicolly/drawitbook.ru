@extends('layouts.base')

@section('content')
    <div class="row clearfix">
        <div class="col-md-8">
            <div class="row">
                <div class="col-12 col-md-1 social-fixed-sidebar order-1">
                    @include('Content::art.social_fixed')
                </div>
                <div class="col-12 col-md-11 order-md-1">
                    <h1 class="title form-group">
                        {{ $article->title }}
                    </h1>
                    {!! $article->template !!}
                </div>
            </div>
        </div>
        <div class="col-md-4 sidebar d-none d-md-block">
            <div class="row">
                <div class="col-12">
                    {!! loadAd('sidebar') !!}
                </div>
            </div>
        </div>
    </div>
@endsection