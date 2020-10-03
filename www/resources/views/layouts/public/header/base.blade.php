<header class="header">
    <div class="header__inner container">
        <div class="header__toggle">
            <i class="hamburger">
                <span class="hamburger__icon header__hamburger-icon"></span>
            </i>
        </div>
        <div class="header__logo">
            <img class="img-responsive" src="{{ buildUrl('img/logo.png') }}" alt="Drawitbook.ru">
        </div>
        <div class="header__search">
            <form class="search-form"
                  role="search"
                  method="get"
                  action="{{ route('search') }}">
                <input class="search-form__input" type="text" name="word" placeholder="Поиск по сайту">
                <button class="search-form__btn" type="submit">
                    <svg role="img" width="20" height="20" viewBox="0 0 20 20">
                        <use xlink:href="{{ getUrlFromManifest('icons/sprite.svg') . '#loupe' }}"></use>
                    </svg>
                </button>
            </form>
        </div>
        <nav class="header__menu">
            <ul class="menu">
                <li class="menu__item"><a class="menu__link header__link" href="#">Главная</a></li>
                <li class="menu__item dropdown">
                    <a class="menu__link header__link dropdown__toggle" href="#">Категории</a>
                    <?php $searchRoute = route('arts.cell') . '/';
                    $groups = [
                        1 => [
                            'птицы' => [
                                'href' => $searchRoute . 'pticy',
                                'items' => [
                                    'орлы' => [
                                        'href' => $searchRoute . 'orel',
                                    ],
                                    'совы' => [
                                        'href' => $searchRoute . 'sova',
                                    ],
                                ],
                            ],
                            'мультфильмы' => [
                                'href' => $searchRoute . 'iz-multfilma',
                                'items' => [
                                    'спанч боб' => [
                                        'href' => $searchRoute . 'spanch-bob'
                                    ],
                                    'винни-пух' => [
                                        'href' => $searchRoute . 'vinni-puh'
                                    ],
                                    'покемоны' => [
                                        'href' => $searchRoute . 'pokemony'
                                    ],
                                    'миньоны' => [
                                        'href' => $searchRoute . 'minon'
                                    ],
                                    'смешарики' => [
                                        'href' => $searchRoute . 'smeshariki'
                                    ],
                                    'симпсоны' => [
                                        'href' => $searchRoute . 'simpsony'
                                    ],
                                    'гравити фолз' => [
                                        'href' => $searchRoute . 'graviti-folz'
                                    ],
                                    'фнаф' => [
                                        'href' => $searchRoute . 'fnaf'
                                    ],
                                    'энгри бердз' => [
                                        'href' => $searchRoute . 'engri-berdz'
                                    ],
                                ],
                            ],
                        ],
                        2 => [
                            'животные' => [
                                'href' => $searchRoute . 'zhivotnye',
                                'items' => [
                                    'кошки' => [
                                        'href' => $searchRoute . 'koshka',
                                    ],
                                    'собачки' => [
                                        'href' => $searchRoute . 'sobachka',
                                    ],
                                    'зайцы' => [
                                        'href' => $searchRoute . 'zayac',
                                    ],
                                    'медведи' => [
                                        'href' => $searchRoute . 'medved',
                                    ],
                                    'лошади' => [
                                        'href' => $searchRoute . 'loshad',
                                    ],
                                    'пони' => [
                                        'href' => $searchRoute . 'poni',
                                    ],
                                ],
                            ],
                            'люди' => [
                                'href' => $searchRoute . 'lyudi',
                                'items' => [
                                    'девочки' => [
                                        'href' => $searchRoute . 'devochka',
                                    ],
                                    'девушки' => [
                                        'href' => $searchRoute . 'devushka',
                                    ],
                                    'мальчики' => [
                                        'href' => $searchRoute . 'malchik',
                                    ],
                                    'портреты' => [
                                        'href' => $searchRoute . 'portret',
                                    ],
                                ],
                            ],
                        ],
                        3 => [
                            'супергерои' => [
                                'href' => $searchRoute . 'supergeroi',
                                'items' => [
                                    'человек-паук' => [
                                        'href' => $searchRoute . 'chelovek-pauk',
                                    ],
                                    'бэтмен' => [
                                        'href' => $searchRoute . 'betmen',
                                    ],
                                    'железный человек' => [
                                        'href' => $searchRoute . 'zheleznyy-chelovek',
                                    ],
                                    'супермен' => [
                                        'href' => $searchRoute . 'supermen',
                                    ],
                                ],
                            ],
                            'фэнтези' => [
                                'href' => $searchRoute . 'fentezi',
                                'items' => [
                                    'единороги' => [
                                        'href' => $searchRoute . 'edinorog',
                                    ],
                                    'драконы' => [
                                        'href' => $searchRoute . 'drakon',
                                    ],
                                ],
                            ],
                            'транспорт' => [
                                'href' => $searchRoute . 'transport',
                                'items' => [
                                    'машины' => [
                                        'href' => $searchRoute . 'mashina',
                                    ],
                                    'корабли' => [
                                        'href' => $searchRoute . 'korabl',
                                    ],
                                    'самолёты' => [
                                        'href' => $searchRoute . 'samolet',
                                    ],
                                ],
                            ],
                        ],
                        4 => [
                            'природа' => [
                                'href' => $searchRoute . 'priroda',
                                'items' => [
                                    'цветы' => [
                                        'href' => $searchRoute . 'cvety',
                                    ],
                                ],
                            ],
                            'прочее' => [
                                'href' => '',
                                'items' => [
                                    'сердечки' => [
                                        'href' => $searchRoute . 'serdechki',
                                    ],
                                    'черепа' => [
                                        'href' => $searchRoute . 'cherep',
                                    ],
                                    'скелеты' => [
                                        'href' => $searchRoute . 'skelet',
                                    ],
                                ],
                            ],
                            'надписи' => [
                                'href' => $searchRoute . 'nadpis',
                                'items' => [
                                    'имена' => [
                                        'href' => $searchRoute . 'imena',
                                    ],
                                    'логотипы' => [
                                        'href' => $searchRoute . 'logotip',
                                    ],
                                    'узоры' => [
                                        'href' => $searchRoute . 'uzor',
                                    ],
                                ],
                            ],
                        ],
                    ]; ?>
                    <div class="dropdown__menu">
                        <div class="dropdown__inner">
                            @foreach($groups as $group)
                                <div class="dropdown__column">
                                    @include('layouts.menu.category', ['groups' => $group])
                                </div>
                            @endforeach
                        </div>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</header>
