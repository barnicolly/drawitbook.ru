@extends('Arts::template.landing')

@section('breadcrumbs')
    {{ Breadcrumbs::render('arts.cell.tagged', mbUcfirst($tag->name)) }}
@endsection

@section('layouts.landing.first_block')
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
@endsection

@section('layouts.landing.content')
    @include('Open::template.stack_grid', ['pictures' => $relativePictures, 'tagged' => route('arts.cell.tagged', '')])
    @if ($countRelatedPictures && !$isLastSlice)
        <div class="download-more form-group">
        <?php $leftPicturesText = pluralForm($countLeftPictures, ['рисунок', 'рисунка', 'рисунков']); ?>
            <button type="button" class="download-more__btn">
                Показать еще <span class="left-pictures-cnt">{{ $leftPicturesText }}</span>
            </button>
        </div>
    @endif
@endsection

@section('layouts.landing.seo')
    <p>
        Если вы хотите сделать креативную открытку своими руками или заполнить дневник оригинальными
        рисунками,
        можно освоить рисование по клеточкам. Картинки по клеточкам - это просто. Хотите научиться классно
        рисовать? Начните с самого простого — с картинок по клеточкам.
        Для это нужна лишь бумага под рукой, да ручка, либо обычный карандаш.
    </p>
@endsection
