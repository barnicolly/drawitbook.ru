@extends('Open::template.layouts.paginated')

@section('layouts.paginated.first_block')
    <h1 class="title form-group">
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
        @elseif (!empty($filters['targetSimilarId']))
            Результаты поиска похожих
        @endif
    </h1>
    @if (!empty($relativePictures))
        <div class="form-group">
            <p>
                Голосуйте за понравившиеся рисунки и делитесь с друзьями.
            </p>
        </div>
    @endif
@endsection

@section('layouts.paginated.content')
    @if (!empty($relativePictures))
        @include('Open::template.stack_grid', ['pictures' => $relativePictures])
    @else
        <div class="search-no-results">
            <div class="search-no-results__img">
                <img src="{{ buildUrl('img/results-not-found.png') }}" class="img-responsive lazyload"
                     alt="По запросу ничего не найдено">
            </div>
            <div class="search-no-results__suggests">
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
                <div>
                    Популярные запросы:
                </div>
                <ul>
                    @foreach($popularQueries as $popularQuery)
                       <li>
                           <a itemprop="url" rel="nofollow"
                              href="{{ route('search') . '?query=' . urlencode($popularQuery) }}">{{ $popularQuery }}</a>
                       </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
@endsection
