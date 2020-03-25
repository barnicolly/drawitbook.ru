@extends('Open::template.layout')

@section('layout.content')
    <div class="block_row detail-art-container">
        <div class="art-container">
            <div class="social-container">
                @include('Open::template.partials.social_fixed')
            </div>
            <div>
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
        <div class="sidebar">
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
