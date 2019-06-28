@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-12">
            <h1 class="title">
                @if (!empty($filters['query']) && !empty($filters['tag']))
                    Результаты поиска по запросу {{ $filters['query'] }} и тегам
                    @foreach($filters['tag'] as $tag)
                        #{{ $tag }}
                    @endforeach
                @elseif (!empty($filters['query']))
                    Результаты поиска по запросу {{ $filters['query'] }}
                @elseif (!empty($filters['tag']))
                    @if (count($filters['tag']) === 1)
                        Результаты поиска по тегу
                        @foreach($filters['tag'] as $tag)
                            #{{ $tag }}
                        @endforeach
                    @else
                        Результаты поиска по тегам
                        @foreach($filters['tag'] as $tag)
                            #{{ $tag }}
                        @endforeach
                    @endif
                @endif
            </h1>
        </div>
    </div>
    @if (!empty($relativePictures))
        <div class="row">
            <div class="col-12 form-group">
                Результатов:
                <span class="badge badge-info">{{ $countRelatedPictures }}</span>
            </div>
            @if (!empty($relativePictures))
                <div class="col-12 form-group">
                    {!! loadAd('before_stack') !!}
                </div>
            @endif
            <div class="col-12 form-group">
                @include('Open::template.stack_grid', ['pictures' => $relativePictures])
            </div>
            <div class="col-12 form-group">
                {!! loadAd('after_first_stack') !!}
            </div>
            @if ($paginate)
                <div class="col-12">
                    {{ $paginate->links() }}
                </div>
            @endif
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <img src="{{ asset('img/results-not-found.png') }}" class="d-block img-fluid m-auto"
                     alt="По запросу ничего не найдено">
            </div>
            <div class="col-12 form-group text-center">
                <p>
                    К сожалению, результатов по запросу не найдено.
                </p>
                <small>
                    Проверьте правильность ввода, попробуйте уменьшить количество слов.
                </small>
                <?php $popularQueries = [
                    'из мультфильма',
                    'животные',
                    'кошечка',
                    'девочки',
                ]; ?>
                <p>
                    Популярные запросы
                    @foreach($popularQueries as $popularQuery)
                        <a itemprop="url" rel="nofollow"
                           href="{{ route('search') . '?query=' . urlencode($popularQuery) }}">{{ $popularQuery }}</a>
                    @endforeach
                </p>
            </div>
        </div>
    @endif
@endsection
