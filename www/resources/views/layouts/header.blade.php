<header class="form-group">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light" itemscope=""
             itemtype="http://schema.org/SiteNavigationElement">
            <a class="navbar-brand " href="{{ route('home') }}" rel="nofollow">
                <img style="max-width: 100px" class="img-responsive" src="{{ asset('img/logo.jpg') }}"
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
                    <?php $megaMenu = Cache::remember('header.mega_menu', config('cache.expiration'), function () {
                        return view('layouts.menu.header-mega')->render();
                    }); ?>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}" rel="nofollow" itemprop="url">
                            <span itemprop="name">Главная</span>
                        </a>
                    </li>
                    {!! $megaMenu !!}
                    @guest
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                ...
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @if (!empty(session('is_admin')))
                                @endif
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}" rel="nofollow"
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
