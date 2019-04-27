@extends('layouts.base')

@section('content')
    <div class="row clearfix">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-11 col-md-push-1 art-container">
                    <h1 class="title form-group">
                        Art #{{ $picture->id }}
                    </h1>
                    <div class="art form-group">
                        <div>
                            @include('Content::template.tag_list', ['tags' => $picture->tags])
                        </div>
                        <div>
                            <figure>
                                <img style="margin: 0 auto; max-height: 755px" class="img-responsive"
                                     src="{{ asset('arts/' . $picture->path) }}">
                                @if($picture->description)
                                    <figcaption>
                                        {{ $picture->description }}
                                    </figcaption>
                                @endif
                            </figure>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                @include('Content::template.rate', ['pictureId' => $picture->id])
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <button type="button" class="btn btn-link pull-right claim-button" data-id="{{ $picture->id }}">
                                    Пожаловаться
                                 </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 social-fixed-sidebar col-md-pull-11">
                    @include('Content::art.social_fixed')
                </div>
            </div>
            <div class="row">
                <div class="col-md-push-1 col-md-11 col-sm-12">
                    {!! loadAd('after_picture') !!}
                </div>
            </div>
        </div>
        <div class="col-md-4 sidebar">
            <div class="row">
                <div class="col-md-12">
                    {!! loadAd('sidebar') !!}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="container">
                <p class="relative-title">
                    Похожие
                </p>
            </div>
        </div>
        <div class="col-md-12">
        </div>
    </div>
@endsection