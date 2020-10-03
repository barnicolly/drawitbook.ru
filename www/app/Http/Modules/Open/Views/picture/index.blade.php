@extends('Open::template.layout')

@section('layout.content')
    <div class="detail-art-page">
        <div class="detail-art-page__content">
            <div class="art-container">
                <div class="content">
                    <h1 class="title form-group">
                        Art #{{ $picture->id }}
                    </h1>
                    <div class="art form-group">
                        <div>
                            @include('Open::template.tag_list', ['tags' => $picture->tags, 'showAllTags' => false])
                        </div>
                        @include('Open::template.img_social', ['picture' => $picture])
                    </div>
                    <div class="form-group clearfix">
                        <button type="button" class="btn btn-link float-right claim-button"
                                data-id="{{ $picture->id }}">
                            Пожаловаться
                        </button>
                    </div>
                </div>
                <div class="content mobile-no-padding">
                    {!! loadAd('after_picture') !!}
                </div>
            </div>
        </div>

        <div class="detail-art-page__sidebar sidebar">
            {!! loadAd('sidebar') !!}
        </div>
    </div>
    @if (!empty($relativePictures) && $relativePictures->count())
        <div class="content">
            <p class="relative-title">
                Похожие
            </p>
            <div>
                @include('Open::template.stack_grid', ['pictures' => $relativePictures])
            </div>
        </div>
    @endif
@endsection
