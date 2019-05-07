@extends('layouts.base')

@section('content')
    <div class="row form-group">
        <div class="col-12">
            <div style="height: 200px; background-color: black"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h2 class="title">
                @if (!empty($filters['query']) && !empty($filters['tag']))
                    Результаты поиска по запросу {{ $filters['query'] }} и тегам
                    @foreach($filters['tag'] as $tag)
                        #{{ $tag }}
                    @endforeach
                @elseif (!empty($filters['query']))
                    Результаты поиска по запросу {{ $filters['query'] }}
                @elseif (!empty($filters['tag']))
                    Результаты поиска по тегам
                    @foreach($filters['tag'] as $tag)
                        #{{ $tag }}
                    @endforeach
                @endif
            </h2>
        </div>
    </div>
    <div class="row">
        @if (!empty($relativePictures))
            <div class="col-12">
                {{ $relativePictures->count() }}
            </div>
            <div class="col-12">
                @include('Content::template.stack_grid', ['pictures' => $relativePictures])
            </div>
        @endif
    </div>
@endsection
