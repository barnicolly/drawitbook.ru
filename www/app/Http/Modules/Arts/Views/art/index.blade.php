@extends('layouts.public.layout')

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
                            @include('Arts::template.stack_grid.art.tag_list', ['tags' => $picture->tags, 'showAllTags' => false])
                        </div>
                        @include('Arts::template.stack_grid.art.img_social', ['picture' => $picture])
                    </div>
                    <div class="form-group clearfix">
                        <button type="button" class="btn btn-link float-right claim-button"
                                data-id="{{ $picture->id }}">
                            Пожаловаться
                        </button>
                    </div>
                </div>
                <div class="content mobile-no-padding">
                    {!! loadAd('after_detail_picture') !!}
                </div>
            </div>
        </div>

        <div class="detail-art-page__sidebar sidebar">
            <div class="theiaStickySidebar">
                <div class="form-group">
                    <h3 class="form-group">
                        Популярные #теги
                    </h3>
                    <div class="tag-list">
                        @foreach($popularTags as $tagName => $tagsSeoName)
                            <a href="{{$tagged . '/' . $tagsSeoName }}"
                               rel="nofollow"
                               itemprop="url"
                               title="Поиск по тегу #{{ $tagName  }}"
                               class="btn btn-link tag">#{{ $tagName }}</a>
                        @endforeach
                    </div>
                </div>
                {!! loadAd('sidebar') !!}
            </div>
        </div>
    </div>
    @if (!empty($relativePictures) && $relativePictures->count())
        <div class="content">
            <p class="relative-title">
                Похожие
            </p>
            <div>
                @include('Arts::template.stack_grid.index', ['pictures' => $relativePictures, 'tagged' => route('arts.cell.tagged', '')])
            </div>
        </div>
    @endif
@endsection
