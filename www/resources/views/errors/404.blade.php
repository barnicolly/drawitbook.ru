@extends('layouts.errors')

@section('errors.title')
    <h1>Страница не найдена или была удалена</h1>
@endsection

@section('errors.content')
    <div>
        <p class="form-group">
            Вы обратились к странице «{{ $incorrectUrl }}».
        </p>
        <p>
            К сожалению, страница не найдена или была удалена. Чтобы найти нужную страницу:
        </p>
        <ul>
            <li>
                проверьте правильность ссылки (если копировали вручную);
            </li>
            <li>
                воспользуйтесь навигацией по сайту.
            </li>
        </ul>
    </div>
@endsection
