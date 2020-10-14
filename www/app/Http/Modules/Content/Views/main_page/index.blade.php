@extends('layouts.public.layout')

@section('layout.body')
    <div class="container">
        <div class="index-page">
            <div class="index-page__content content">
                <h1>
                    Drawitbook.ru
                </h1>
                <p>
                    На сайте собрано <span>2&nbsp;749</span> <strong>рисунков по клеточкам</strong>.
                </p>
                <p>
                    Воспользуйтесь поиском по сайту или <a href="#tag-list">облаком тегов</a> чтобы найти что-то конкретное.
                </p>
                <p>
                    Голосуйте за понравившиеся рисунки и делитесь с друзьями.
                </p>
                <div id="tag-list">
                    <div id="tagContainer"></div>
                </div>
            </div>
            <div class="index-page__img">
                <img class="img-responsive lazyload" data-src="{{ buildUrl('img/promo.png') }}" alt="Drawitbook.ru">
            </div>
        </div>
    </div>
@endsection
