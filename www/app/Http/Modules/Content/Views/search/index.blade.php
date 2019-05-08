@extends('layouts.base')

@section('content')
    <div class="row form-group">
        <div class="col-12">
            {!! loadAd('before_stack') !!}
        </div>
    </div>
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
            <div class="col-12 form-group">
                @include('Content::template.stack_grid', ['pictures' => $relativePictures])
            </div>
            @if ($paginate)
                <div class="row">
                    <div class="col-12">
                        {{ $paginate->links() }}
                    </div>
                </div>
            @endif
            <div class="col-12 form-group">
                {!! loadAd('after_first_stack') !!}
            </div>
        </div>
    @endif
@endsection
