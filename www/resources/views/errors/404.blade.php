@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <img src="{{ asset('img/page-not-found.png') }}" class="d-block img-fluid m-auto"
                 alt="По запросу ничего не найдено">
        </div>
        <div class="col-md-8 text-left">
            <div style="padding-top: 100px;">
                <p>
                    К сожалению, страница не найдена или была удалена.
                </p>
                <small>
                    Проверьте правильность ввода или воспользуйтесь поиском и навигацией по сайту.
                </small>
            </div>
        </div>
    </div>
@endsection
