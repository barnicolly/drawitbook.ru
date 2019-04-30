@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="col-12 form-group">
            <a href="{{ route('create_article') }}">
                Создать
            </a>
        </div>
        <div class="col-12">
            <table class="table table-sm">
                <thead>
                <th>#</th>
                <th>Заголовок</th>
                <th>Описание</th>
                <th>Статус</th>
                <th></th>
                </thead>
                <tbody>
                @foreach($articles as $article)
                    <tr>
                        <td>{{ $article->id }}</td>
                        <td>{{ $article->title }}</td>
                        <td>{{ $article->description }}</td>
                        <td>{{ $article->is_show ? 'Показ.' : 'Скрыт' }}</td>
                        <td>
                            <a href="{{ route('edit_article', ['id' => $article->id]) }}">>>></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection