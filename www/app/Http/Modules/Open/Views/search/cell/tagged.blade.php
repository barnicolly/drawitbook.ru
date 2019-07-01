@extends('layouts.base')

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

@section('content')
    <div class="row">
        <div class="col-12 form-group">
            <h1 class="title">
                Рисунки по клеточкам «{{ mbUcfirst($tag->name) }}»‎
            </h1>
            <p class="form-group">
                Рисовать по клеточкам любит практически каждый ребенок и взрослый. Это очень легко, ведь для этого нужна
                только тетрадь в клеточку. <strong>Рисунки по клеточкам на тему «{{ mbUcfirst($tag->name) }}»‎</strong>
                от легких и простых до сложных схем.
                Рисунки подобраны не только для деток 4-5 лет, и 6-7, и 8-9-10 лет, но и для взрослых.
            </p>
        </div>
        <div class="col-12 form-group">
            Результатов:
            <span class="badge badge-info">{{ $countRelatedPictures }}</span>
            &nbsp;&nbsp;
            @if ($paginate && ($paginate->lastPage() !== 1))
                <p class="d-md-inline-block form-group">
                    Страница <span class="badge badge-info">{{ $paginate->currentPage() }}
                        из {{ $paginate->lastPage() }}</span>
                </p>
            @endif
        </div>
        @if ($paginate && ($paginate->lastPage() !== 1))
            <div class="col-12">
                {{ $paginate->links() }}
            </div>
        @endif
        <div class="col-12 form-group">
            {!! loadAd('before_stack') !!}
        </div>
        <div class="col-12 form-group">
            @include('Open::template.stack_grid', ['pictures' => $relativePictures, 'tagged' => route('arts.cell.tagged', '')])
        </div>
        {{--        //TODO-misha Заинтересовать чем-то еще в конце --}}

        @if ($paginate && ($paginate->lastPage() !== 1))
            <div class="col-12 form-group">
                <p class="d-inline-block">
                    Страница <span class="badge badge-info">{{ $paginate->currentPage() }}
                        из {{ $paginate->lastPage() }}</span>
                </p>&nbsp;&nbsp;
                <div class="d-inline-block">
                    {{ $paginate->links() }}
                </div>
            </div>
        @endif
        <div class="col-12 form-group">
            {!! loadAd('after_first_stack') !!}
        </div>
        @if ($paginate && $paginate->currentPage() === 1 && !$canonical)
            <div class="col-12 form-group">
                <p>
                    Если вы хотите сделать креативную открытку своими руками или заполнить дневник оригинальными
                    рисунками,
                    можно освоить рисование по клеточкам. Картинки по клеточкам - это просто. Хотите научиться классно
                    рисовать? Начните с самого простого — с картинок по клеточкам.
                    Для это нужна лишь бумага под рукой, да ручка, либо обычный карандаш.
                </p>
            </div>
        @endif
    </div>

    <div class="social-fixed-right-wrapper .d-sm-none .d-md-block">
        <div class="social-fixed-right">
            @include('Open::picture.social_fixed')
        </div>
    </div>

@endsection
