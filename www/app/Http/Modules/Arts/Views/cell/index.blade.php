@extends('Open::template.layout')

@section('breadcrumbs')
    {{ Breadcrumbs::render('arts.cell') }}
@endsection

@section('layout.content')
    <div class="content">
        <h1 class="title form-group">
            Рисунки по клеточкам
        </h1>
        <div class="form-group">
            <p>
                Рисовать по клеточкам любит практически каждый ребенок и взрослый. Это очень легко, ведь для этого нужна
                только тетрадь в клеточку. <strong>Рисунки по клеточкам</strong>
                от легких и простых до сложных схем.
                Рисунки подобраны не только для деток 4-5 лет, и 6-7, и 8-9-10 лет, но и для взрослых.
            </p>
            <p>
                Голосуйте за понравившиеся рисунки и делитесь с друзьями.
            </p>
        </div>
    </div>
    <div class="form-group mobile-no-padding content">
        {!! loadAd('before_stack') !!}
    </div>
    <div class="content">
        @include('Open::template.stack_grid', ['pictures' => $relativePictures, 'tagged' => route('arts.cell.tagged', '')])
    </div>
    <div class="form-group mobile-no-padding content">
        {!! loadAd('after_first_stack') !!}
    </div>
@endsection
