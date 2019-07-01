<li class="nav-item dropdown megamenu-li">
    <a class="nav-link dropdown-toggle" href="" rel="nofollow" id="dropdown01" data-toggle="dropdown" aria-haspopup="true"
       aria-expanded="false">Категории</a>
    <div class="dropdown-menu megamenu" aria-labelledby="dropdown01">
        <div class="row">
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
            <div class="col-sm-6 col-lg-3">
                @include('layouts.menu.category', ['groups' => $groups[1]])
            </div>
            <div class="col-sm-6 col-lg-3">
                @include('layouts.menu.category', ['groups' => $groups[2]])
            </div>
            <div class="col-sm-6 col-lg-3">
                @include('layouts.menu.category', ['groups' => $groups[3]])
            </div>
            <div class="col-sm-6 col-lg-3">
                @include('layouts.menu.category', ['groups' => $groups[4]])
            </div>
        </div>
</li>