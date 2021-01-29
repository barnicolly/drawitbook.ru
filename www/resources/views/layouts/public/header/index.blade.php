<header class="header">
    <div class="header__inner container">
        <div class="header__toggle">
            <i class="hamburger">
                <span class="hamburger__icon header__hamburger-icon"></span>
            </i>
        </div>
        <div class="header__logo">
            <a href="{{ route('home') }}" rel="nofollow">
                <img class="img-responsive header__logo-img" src="{{ buildUrl('img/logo.png') }}" alt="Drawitbook.com">
            </a>
        </div>
        <div class="header__search">
            <form class="search-form"
                  role="search"
                  method="get"
                  action="{{ route('search') }}">
                <input class="search-form__input"
                       type="search"
                       name="query"
                       placeholder="{!! __('pages.layout.header.search.placeholder') !!}"
                       value="{{ $searchQuery ?? '' }}">
                <button class="search-form__btn" type="submit">
                    <svg role="img" width="20" height="20" viewBox="0 0 20 20">
                        <use xlink:href="{{ getUrlFromManifest('icons/sprite.svg') . '#loupe' }}"></use>
                    </svg>
                </button>
            </form>
        </div>
        <nav class="header__menu">
            <div class="container">
                <ul class=" menu">
                    <li class="menu__item">
                        <a class="menu__link header__link" href="{{ route('home') }}" rel="nofollow" itemprop="url">
                            {!! __('pages.layout.header.menu.home') !!}
                        </a>
                    </li>
                    <li class="menu__item dropdown">
                        <a class="menu__link header__link dropdown__toggle" href="#">{!! __('pages.layout.header.menu.categories') !!}</a>
                        <div class="dropdown__menu categories-dropdown">
                            <div class="dropdown__inner">
                                @foreach($groups as $group)
                                    <div class="dropdown__column">
                                        @include('layouts.public.header.menu.column', ['parts' => $group])
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
