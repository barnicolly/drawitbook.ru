@extends('layouts.admin')


@section('content')
    <div class="col-12">
        <p>
            Обзор статей
        </p>
    </div>
    <div class="col-12">
        <a href="{{ route('create_article') }}">
            Создать
        </a>
    </div>
@endsection