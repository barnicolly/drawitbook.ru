@extends('Open::template.layout')

@section('breadcrumbs')
    {{ Breadcrumbs::render('arts.cell.tagged', mbUcfirst($tag->name)) }}
@endsection

@push('links')
    @if (!empty($canonical))
        <link rel="canonical" href="{{ $canonical }}">
    @endif
    @if ($links)
        @foreach($links as $rel => $link)
            <link rel="{{ $rel }}" href="{{ $link }}">
        @endforeach
    @endif
@endpush

@section('layout.content')
    <h1 class="title form-group">
        Рисунки по клеточкам «{{ mbUcfirst($tag->name) }}»
    </h1>
    <div class="form-group">
        <p>
            Рисовать по клеточкам любит практически каждый ребенок и взрослый. Это очень легко, ведь для этого нужна
            только тетрадь в клеточку. <strong>Рисунки по клеточкам на тему «{{ mbUcfirst($tag->name) }}»</strong>
            от легких и простых до сложных схем.
            Рисунки подобраны не только для деток 4-5 лет, и 6-7, и 8-9-10 лет, но и для взрослых.
        </p>
    </div>
    <div>
        <div class="d-inline">
            Результатов:
            <span class="badge badge-info">{{ $countRelatedPictures }}</span>
        </div>
        @if ($paginate && ($paginate->lastPage() !== 1))
            <div class="d-inline">
                <p class="content">
                    Страница <span class="badge badge-info">{{ $paginate->currentPage() }}
                        из {{ $paginate->lastPage() }}</span>
                </p>
            </div>
        @endif
        @if ($paginate && ($paginate->lastPage() !== 1))
            <div>
                {{ $paginate->links() }}
            </div>
        @endif
    </div>
    <div class="form-group">
        {!! loadAd('before_stack') !!}
    </div>
    <div>
        @include('Open::template.stack_grid', ['pictures' => $relativePictures, 'tagged' => route('arts.cell.tagged', '')])
    </div>
    @if ($paginate && ($paginate->lastPage() !== 1))
        <div>
            Страница <span class="badge badge-info">{{ $paginate->currentPage() }}
                        из {{ $paginate->lastPage() }}</span>
        </div>
        <div>
            {{ $paginate->links() }}
        </div>
    @endif
    <div class="form-group">
        {!! loadAd('after_first_stack') !!}
    </div>
    @if ($paginate && $paginate->currentPage() === 1 && !$canonical)
        <div class="form-group">
            <p>
                Если вы хотите сделать креативную открытку своими руками или заполнить дневник оригинальными
                рисунками,
                можно освоить рисование по клеточкам. Картинки по клеточкам - это просто. Хотите научиться классно
                рисовать? Начните с самого простого — с картинок по клеточкам.
                Для это нужна лишь бумага под рукой, да ручка, либо обычный карандаш.
            </p>
        </div>
    @endif
    <div class="social-fixed-right-wrapper">
        <div class="social-fixed-right">
            @include('Open::picture.social_fixed')
        </div>
    </div>
@endsection
