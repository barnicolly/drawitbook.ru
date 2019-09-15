@extends('layouts.base')

@section('content')
    <div id="mainPageContainer" class="clearfix">
        <div class="row first-container">
            <div class="col-lg-7 col-12">
                <h1 style="padding-top: 50px;">
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
            <div class="col-lg-5 col-12">
                <img class="img-fluid lazyload" data-src="{{ asset('img/promo.png') }}" alt="">
            </div>
        </div>
    </div>
@endsection





