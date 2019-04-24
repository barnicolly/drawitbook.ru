@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-1 social-fixed-sidebar">
                    @include('Content::art.social_fixed')
                </div>
                <div class="col-md-11">
                    <h1 class="title form-group">
                        Art #{{ $picture->id }}
                    </h1>
                    <div class="form-group">
                        @include('Content::template.tag_list', ['tags' => $picture->tags])
                    </div>
                    <div class="form-group">
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
                    <div>
                        {!! loadAd('after_picture') !!}
                    </div>
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