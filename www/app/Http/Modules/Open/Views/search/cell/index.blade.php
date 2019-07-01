@extends('layouts.base')

@section('breadcrumbs')
    {{ Breadcrumbs::render('arts.cell') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12 form-group">
            <h1 class="title">
                Рисунки по клеточкам
            </h1>
            <p class="form-group">
                Рисовать по клеточкам любит практически каждый ребенок и взрослый. Это очень легко, ведь для этого нужна
                только тетрадь в клеточку. <strong>Рисунки по клеточкам‎</strong>
                от легких и простых до сложных схем.
                Рисунки подобраны не только для деток 4-5 лет, и 6-7, и 8-9-10 лет, но и для взрослых.
            </p>
        </div>
        <div class="col-12 form-group">
            {!! loadAd('before_stack') !!}
        </div>
        <div class="col-12 form-group">
            @include('Open::template.stack_grid', ['pictures' => $relativePictures, 'tagged' => route('arts.cell.tagged', '')])
        </div>
        <div class="col-12 form-group">
            {!! loadAd('after_first_stack') !!}
        </div>
    </div>

    <div class="social-fixed-right-wrapper .d-sm-none .d-md-block">
        <div class="social-fixed-right">
            @include('Open::picture.social_fixed')
        </div>
    </div>
@endsection
