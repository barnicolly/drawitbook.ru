<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class HeaderComposer
{
    public function compose(View $view)
    {
        $viewData = [
            'groups' => $this->formGroups(),
        ];
        return $view->with($viewData);
    }

    private function formGroups(): array
    {
        $result = [];
        $map = $this->getMapHrefTitle();
        $scheme = $this->getScheme();
        foreach ($scheme as $items) {
            $groups = [];
            foreach ($items as $item) {
                $slug = $item['parent'][0] ?? '';
                $node = [
                    'slug' => $slug,
                    'title' => $item['parent'][1] ?: $map[$slug] ?? '',
                    'items' => [],
                ];
                foreach ($item['items'] as $sumItem) {
                    $slug = $sumItem[0] ?? '';
                    $node['items'][] = [
                        'slug' => $slug,
                        'title' => $sumItem[1] ?: $map[$slug] ?? '',
                    ];
                }

                $titles = array_column($node['items'], 'title');
                array_multisort($titles, SORT_ASC, $node['items']);
                $groups[] = $node;
            }
            $result[] = $groups;
        }
        return $result;
    }

    private function getScheme(): array
    {
        return [
            [
                [
                    'parent' => ['pticy', ''],
                    'items' => [
                        ['sova', ''],
                        ['orel', ''],
                    ]
                ],
                [
                    'parent' => ['iz-multfilma', ''],
                    'items' => [
                        ['spanch-bob', ''],
                        ['vinni-puh', ''],
                        ['pokemony', ''],
                        ['minon', ''],
                        ['smeshariki', ''],
                        ['smeshariki', ''],
                        ['simpsony', ''],
                        ['graviti-folz', ''],
                        ['fnaf', ''],
                        ['engri-berdz', ''],
                    ]
                ],
            ],
            [
                [
                    'parent' => ['zhivotnye', ''],
                    'items' => [
                        ['orel', ''],
                        ['sova', ''],
                        ['koshka', ''],
                        ['sobachka', ''],
                        ['zayac', ''],
                        ['medved', ''],
                        ['loshad', ''],
                        ['poni', ''],
                    ]
                ],
                [
                    'parent' => ['lyudi', ''],
                    'items' => [
                        ['devochka', ''],
                        ['devushka', ''],
                        ['malchik', ''],
                        ['portret', ''],
                    ]
                ],
            ],
            [
                [
                    'parent' => ['supergeroi', ''],
                    'items' => [
                        ['chelovek-pauk', ''],
                        ['betmen', ''],
                        ['zheleznyy-chelovek', ''],
                        ['supermen', ''],
                    ]
                ],
                [
                    'parent' => ['fentezi', ''],
                    'items' => [
                        ['edinorog', ''],
                        ['drakon', ''],
                    ]
                ],
                [
                    'parent' => ['transport', ''],
                    'items' => [
                        ['mashina', ''],
                        ['korabl', ''],
                        ['samolet', ''],
                    ]
                ],
            ],
            [
                [
                    'parent' => ['priroda', ''],
                    'items' => [
                        ['cvety', ''],
                    ]
                ],
                [
                    'parent' => ['', 'прочее'],
                    'items' => [
                        ['serdechki', ''],
                        ['cherep', ''],
                        ['skelet', ''],
                    ]
                ],
                [
                    'parent' => ['nadpis', ''],
                    'items' => [
                        ['imena', ''],
                        ['logotip', ''],
                        ['uzor', ''],
                    ]
                ],
            ]
        ];
    }

    private function getMapHrefTitle(): array
    {
        return [
            'nadpis' => 'надписи',
            'imena' => 'имена',
            'logotip' => 'логотипы',
            'uzor' => 'узоры',
            'serdechki' => 'сердечки',
            'cherep' => 'черепа',
            'skelet' => 'скелеты',
            'priroda' => 'природа',
            'cvety' => 'цветы',
            'supergeroi' => 'супергерои',
            'chelovek-pauk' => 'человек-паук',
            'betmen' => 'бэтмен',
            'zheleznyy-chelovek' => 'железный человек',
            'supermen' => 'супермен',
            'samolet' => 'самолёты',
            'korabl' => 'корабли',
            'mashina' => 'машины',
            'transport' => 'транспорт',
            'fentezi' => 'фэнтези',
            'edinorog' => 'единороги',
            'drakon' => 'драконы',
            'lyudi' => 'люди',
            'devochka' => 'девочки',
            'devushka' => 'девушки',
            'malchik' => 'мальчики',
            'portret' => 'портреты',
            'zhivotnye' => 'животные',
            'koshka' => 'кошки',
            'sobachka' => 'собачки',
            'zayac' => 'зайцы',
            'medved' => 'медведи',
            'loshad' => 'лошади',
            'poni' => 'пони',
            'pticy' => 'птицы',
            'orel' => 'орлы',
            'sova' => 'совы',
            'iz-multfilma' => 'мультфильмы',
            'spanch-bob' => 'спанч боб',
            'vinni-puh' => 'винни-пух',
            'pokemony' => 'покемоны',
            'minon' => 'миньоны',
            'smeshariki' => 'смешарики',
            'simpsony' => 'симпсоны',
            'graviti-folz' => 'гравити фолз',
            'fnaf' => 'фнаф',
            'engri-berdz' => 'энгри бердз',
        ];
    }
}
