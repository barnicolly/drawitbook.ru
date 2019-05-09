<li class="nav-item dropdown megamenu-li">
    <a class="nav-link dropdown-toggle" href="" id="dropdown01" data-toggle="dropdown" aria-haspopup="true"
       aria-expanded="false">Категории</a>
    <div class="dropdown-menu megamenu" aria-labelledby="dropdown01">
        <div class="row">
            <?php $searchRoute = route('search');
            $groups = [
                1 => [
                    'птицы' => [
                        'href' => $searchRoute . '?tag[]=птицы',
                        'items' => [
                            'орлы' => [
                                'href' => $searchRoute . '?tag[]=орел',
                            ],
                            'совы' => [
                                'href' => $searchRoute . '?tag[]=сова',
                            ],
                        ],
                    ],
                    'мультфильмы' => [
                        'href' => $searchRoute . '?tag[]=из+мультфильма',
                        'items' => [
                            'спанч боб' => [
                                'href' => $searchRoute . '?tag[]=спанч+боб'
                            ],
                            'винни-пух' => [
                                'href' => $searchRoute . '?tag[]=винни-пух'
                            ],
                            'покемоны' => [
                                'href' => $searchRoute . '?tag[]=покемоны'
                            ],
                            'миньоны' => [
                                'href' => $searchRoute . '?tag[]=миньон'
                            ],
                            'смешарики' => [
                                'href' => $searchRoute . '?tag[]=смешарики'
                            ],
                            'симпсоны' => [
                                'href' => $searchRoute . '?tag[]=симпсоны'
                            ],
                            'гравити фолз' => [
                                'href' => $searchRoute . '?tag[]=гравити+фолз'
                            ],
                            'фнаф' => [
                                'href' => $searchRoute . '?tag[]=фнаф'
                            ],
                            'энгри бердз' => [
                                'href' => $searchRoute . '?tag[]=энгри%20бердз'
                            ],
                        ],
                    ],
                ],
                2 => [
                    'животные' => [
                        'href' => $searchRoute . '?tag[]=животные',
                        'items' => [
                            'кошки' => [
                                'href' => $searchRoute . '?tag[]=кошка',
                            ],
                            'собачки' => [
                                'href' => $searchRoute . '?tag[]=собачка',
                            ],
                            'зайцы' => [
                                'href' => $searchRoute . '?tag[]=заяц',
                            ],
                            'медведи' => [
                                'href' => $searchRoute . '?tag[]=медведь',
                            ],
                            'лошади' => [
                                'href' => $searchRoute . '?tag[]=лошадь',
                            ],
                            'пони' => [
                                'href' => $searchRoute . '?tag[]=пони',
                            ],
                        ],
                    ],
                    'люди' => [
                        'href' => $searchRoute . '?tag[]=люди',
                        'items' => [
                            'девочки' => [
                                'href' => $searchRoute . '?tag[]=девочка',
                            ],
                            'девушки' => [
                                'href' => $searchRoute . '?tag[]=девушка',
                            ],
                            'мальчики' => [
                                'href' => $searchRoute . '?tag[]=мальчик',
                            ],
                            'портреты' => [
                                'href' => $searchRoute . '?tag[]=портрет',
                            ],
                        ],
                    ],
                ],
                3 => [
                    'супергерои' => [
                        'href' => $searchRoute . '?tag[]=супергерои',
                        'items' => [
                            'человек-паук' => [
                                'href' => $searchRoute . '?tag[]=человек-паук',
                            ],
                            'бэтмен' => [
                                'href' => $searchRoute . '?tag[]=бэтмен',
                            ],
                            'железный человек' => [
                                'href' => $searchRoute . '?tag[]=железный+человек',
                            ],
                            'супермен' => [
                                'href' => $searchRoute . '?tag[]=супермен',
                            ],
                        ],
                    ],
                    'фэнтези' => [
                        'href' => $searchRoute . '?tag[]=фэнтези',
                        'items' => [
                            'единороги' => [
                                'href' => $searchRoute . '?tag[]=единорог',
                            ],
                            'драконы' => [
                                'href' => $searchRoute . '?tag[]=дракон',
                            ],
                        ],
                    ],
                    'транспорт' => [
                        'href' => $searchRoute . '?tag[]=транспорт',
                        'items' => [
                            'машины' => [
                                'href' => $searchRoute . '?tag[]=машина',
                            ],
                            'корабли' => [
                                'href' => $searchRoute . '?tag[]=корабль',
                            ],
                            'самолёты' => [
                                'href' => $searchRoute . '?tag[]=самолёты',
                            ],
                        ],
                    ],
                ],
                4 => [
                    'природа' => [
                        'href' => $searchRoute . '?tag[]=природа',
                        'items' => [
                            'цветы' => [
                                'href' => $searchRoute . '?tag[]=цветы',
                            ],
                        ],
                    ],
                    'прочее' => [
                        'href' => '',
                        'items' => [
                            'сердечки' => [
                                'href' => $searchRoute . '?tag[]=сердечки',
                            ],
                            'черепа' => [
                                'href' => $searchRoute . '?tag[]=череп',
                            ],
                            'скелеты' => [
                                'href' => $searchRoute . '?tag[]=скелет',
                            ],
                        ],
                    ],
                    'надписи' => [
                        'href' => $searchRoute . '?tag[]=надпись',
                        'items' => [
                            'имена' => [
                                'href' => $searchRoute . '?tag[]=имена',
                            ],
                            'логотипы' => [
                                'href' => $searchRoute . '?tag[]=логотип',
                            ],
                            'узоры' => [
                                'href' => $searchRoute . '?tag[]=узор',
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