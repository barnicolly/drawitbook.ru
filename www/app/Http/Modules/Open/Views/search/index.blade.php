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
        @endif
    </h1>
@endsection

@section('layouts.paginated.content')
    @if (!empty($relativePictures))
        @include('Open::template.stack_grid', ['pictures' => $relativePictures])
    @else
        <div>
            <img src="{{ asset('img/results-not-found.png') }}" class=""
                 alt="По запросу ничего не найдено">
        </div>
        <div class="form-group text-center">
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
    @endif
@endsection
