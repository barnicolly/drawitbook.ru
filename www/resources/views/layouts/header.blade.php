<header>
    <nav class="navbar navbar-default" itemscope="" itemtype="http://schema.org/SiteNavigationElement">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand " href="{{ route('home') }}">
                            <img style="max-width: 100px" class="img-responsive" src="{{ asset('img/logo.png') }}"
                                 alt="">
                        </a>
                    </div>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <div class="col-md-9">
                            <div class="navbar-form">
                                <input type="text" class="form-control" style="width: 100%" placeholder="Поиск">
                            </div>
                        </div>
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="{{ route('home') }}">Главная</a>
                            </li>
                            @guest
                                <li>
                                    <a href="{{ route('login') }}">Войти</a>
                                </li>
                                @if (Route::has('register'))
                                    <li>
                                        <a href="{{ route('register') }}">Регистрация</a>
                                    </li>
                                @endif
                            @else
                                <li>
                                    <a href="#"></a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">...
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="#">
                                                Добавить аккаунт
                                            </a>
                                        </li>
                                        <li role="separator" class="divider"></li>
                                        <li>
                                            <a href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                Выход
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                  style="display: none;">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>