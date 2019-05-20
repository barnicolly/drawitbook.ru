@extends('layouts.base')

@section('content')
    <div class="row clearfix">
        <div class="col-md-8">
            <div class="row">
                <div class="col-12 col-md-1 social-fixed-sidebar order-1">
                    @include('Open::picture.social_fixed')
                </div>
                <div class="col-12 col-md-11 art-container order-md-1">
                    <h1 class="title form-group">
                        Art #{{ $picture->id }}
                    </h1>
                    <div class="art form-group">
                        <div>
                            @include('Open::template.tag_list', ['tags' => $picture->tags, 'showAllTags' => false])
                        </div>
                        @include('Open::template.img_social', ['picture' => $picture])
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 float-right">
                                <button type="button" class="btn btn-link float-right claim-button"
                                        data-id="{{ $picture->id }}">
                                    Пожаловаться
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    {!! loadAd('after_picture') !!}
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
    @if (!empty($relativePictures) && $relativePictures->count())
        <div class="row">
            <div class="col-12">
                <div class="container">
                    <p class="relative-title">
                        Похожие
                    </p>
                </div>
            </div>
            <div class="col-12">
                @include('Content::template.stack_grid', ['pictures' => $relativePictures])
            </div>
        </div>
    @endif
@endsection