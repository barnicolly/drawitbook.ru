@extends('layouts.base')

@section('breadcrumbs')
    {{ Breadcrumbs::render('arts.cell.search.tagged', mbUcfirst($tag->name)) }}
@endsection

@push('links')
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
                только тетрадь в клеточку. <strong>Рисунки по клеточкам на тему «{{ mbUcfirst($tag->name) }}»‎</strong> от легких и простых до сложных схем.
                Рисунки подобраны и для деток 4-5 лет, и 6-7, и 8-9-10 лет, и даже старше.
            </p>
        </div>
        <div class="col-12 form-group">
            Результатов:
            <span class="badge badge-info">{{ $countRelatedPictures }}</span>
        </div>
        <div class="col-12 form-group">
            {!! loadAd('before_stack') !!}
        </div>
        <div class="col-12 form-group">
            @include('Open::template.stack_grid', ['pictures' => $relativePictures, 'tagged' => route('risunkiPoKletochkam.tagged', '')])
        </div>
        <div class="col-12 form-group">
            {!! loadAd('after_first_stack') !!}
        </div>
        @if ($paginate)
            <div class="row">
                <div class="col-12">
                    {{ $paginate->links() }}
                </div>
            </div>
        @endif
    </div>

@endsection
