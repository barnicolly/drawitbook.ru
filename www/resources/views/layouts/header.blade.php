<header class="form-group">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand " href="{{ route('home') }}">
                <img style="max-width: 100px" class="img-fluid" src="{{ asset('img/logo.jpg') }}"
                     alt="">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02"
                    aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <form action="{{ route('search') }}" method="GET" class="form-inline search-form col-md-8">
                    <div class="input-group">
                        <input class="form-control"
                               name="query"
                               type="search"
                               placeholder="Поиск"
                               value="{{ !empty($filters['query']) ? $filters['query']: '' }}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-info" type="submit">Поиск</button>
                        </div>
                    </div>
                </form>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Главная</a>
                    </li>
                    @include('layouts.menu.header-mega')
                    @guest
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                ...
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @if (!empty(session('is_admin')))
                                    <a class="dropdown-item" href="{{ route('show_articles') }}">
                                        Статьи
                                    </a>
                                    <a class="dropdown-item" href="{{ route('moderate') }}">
                                        Модерация артов
                                    </a>
                                @endif
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Выход
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>
    </div>
</header>
