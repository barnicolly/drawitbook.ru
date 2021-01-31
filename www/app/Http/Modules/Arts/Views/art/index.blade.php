@extends('layouts.public.layout', ['showSocial' => true])

@section('layout.content')
    <div class="detail-art-page">
        <div class="detail-art-page__content">
            <div class="art-container">
                <div class="content">
                    <h1 class="title form-group">
                        Art #{{ $art['id'] }}
                    </h1>
                    <div class="art form-group">
                        @if (!empty($art['tags']))
                            <div>
                                @include('Arts::template.stack_grid.art.tag_list', ['tags' => $art['tags']])
                            </div>
                        @endif
                        @include('Arts::template.stack_grid.art.img_social', ['art' => $art])
                    </div>
                    <div class="form-group clearfix">
                        <button type="button" class="btn btn-link float-right claim-button"
                                data-id="{{ $art['id'] }}">
                            {{ __('common.claim') }}
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
                        {{ __('common.popular_hash_tags') }}
                    </h3>
                    <div class="tag-list">
                        @include('Arts::template.stack_grid.art.tag_list', ['tags' => $popularTags])
                    </div>
                </div>
                {!! loadAd('sidebar') !!}
            </div>
        </div>
    </div>
    @if (!empty($arts))
        <div class="content">
            <p class="relative-title">
                {{ __('common.similar') }}
            </p>
            <div>
                @include('Arts::template.stack_grid.index', ['arts' => $arts])
            </div>
        </div>
    @endif
@endsection
