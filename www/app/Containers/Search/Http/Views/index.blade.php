@extends('Arts::template.landing')

@section('layouts.landing.first_block')
    <h1 class="title form-group">
        @if (!empty($filters['query']))
            {!! __('pages.search.h1_by_query', ['query' => $filters['query']]) !!}
        @endif
    </h1>
    @if (!empty($arts))
        <div class="form-group">
            <p>
                {!! __('pages.search.vote_liked') !!}
            </p>
        </div>
    @endif
@endsection

@section('layouts.landing.content')
    @if (!empty($arts))
        @include('Arts::template.stack_grid.index', ['arts' => $arts])
    @else
        <div class="search-no-results">
            <div class="search-no-results__img">
                <img src="{{ buildUrl('img/results-not-found.png') }}" class="img-responsive lazyload"
                     alt="{{ __('pages.search.img_not_found_alt') }}">
            </div>
            <div class="search-no-results__suggests">
                <p>
                    {{ __('pages.search.not_found_results_title') }}
                </p>
                <small>
                    {{ __('pages.search.suggest') }}
                </small>
                <div>
                    {{ __('pages.search.popular_tags') }}:
                </div>
                <ul>
                    @foreach($popularTags as $tag)
                        <li>
                            <a itemprop="url"
                               rel="follow"
                               title="{{ $tag['link_title'] }}"
                               href="{{ $tag['link'] }}">
                                {{ $tag['name'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @if (!empty($popularArts))
            <div class="content form-group">
                <h2>
                    {!! __('pages.search.popular_arts') !!}
                </h2>
            </div>
            <div class="content">
                @include('Arts::template.stack_grid.index', ['arts' => $popularArts])
            </div>
        @endif
    @endif
@endsection
