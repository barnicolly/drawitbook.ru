<?php

namespace App\Http\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;

//use Illuminate\Database\Eloquent\Collection;
//use Illuminate\Http\Request;
use Validator;

class TagRules extends Controller
{

    private $_rules = [
        'no_tag' => [
            'легкие' => 'сложные',
            'черно-белые' => 'цветные',
        ],
        'append' => [
            'люди' => [
                'девочка',
                'мальчик',
                'девушка',
            ],
            'овощи' => [
                'овощ',
                'огурец',
                'помидор',
            ],
            'ягоды' => [
                'ягода',
                'земляника',
                'черника',
                'клубника',
                'ежевика',
                'виноград',
            ],
            'фрукты' => [
                'лимон',
                'фрукт',
                'яблоко',
                'банан',
                'апельсин',
                'груша',
            ],
            'мороженое' => [
                'эскимо',
            ],
            'еда' => [
                'ягоды',
                'фрукты',
                'мороженое',
                'овощи',
                'суши',
                'торт',
                'сыр',
                'леденец',
                'гамбургер',
                'пирог',
            ],
            'домашние животные' => [
                'кошка',
                'кот',
                'котенок',
                'кошечка',
                'кошка',
                'далматинец',
                'собачка',
                'собака',
                'щенок',
            ],
            'морские животные' => [
                'морская звезда',
                'рыба',
                'рыбка',
                'черепаха',
            ],
            'животные' => [
                'мышонок',
                'барашек',
                'мышь',
                'орел',
                'лисицы',
                'дельфин',
                'динозавр',
                'зайчик',
                'крокодил',
                'лисенок',
                'лисичка',
                'лошадь',
                'львенок',
                'медвежонок',
                'медведь',
                'обезьяна',
                'олененок',
                'олень',
                'панда',
                'свинья',
                'птицы',
                'насекомые',
                'морские животные',
                'домашние животные',
            ],
            'насекомые' => [
                'бабочка',
                'бабочки',
            ],
            'птицы' => [
                'пингвин',
                'птица',
                'попугай',
                'сова',
                'совы',
                'цыпленок',
                'цыплята',
            ],
            'для девочек' => [
                'прическа',
                'пони',
                'роза',
                'сердечки',
                'сердца',
                'сердце',
                'украшение',
                'украшения',
                'цветок',
            ],
            'для мальчиков' => [
                'халк',
                'оружие',
                'майнкрафт',
                'minecraft',
            ],
        ],
        'not_compatible' => [
            ['легкие', 'сложные'],
            ['домашние животные', 'животные', 'еда', 'насекомые'],
        ],
    ];

    public function appendByRules(array $tags)
    {
        $result = $tags;
        foreach ($tags as $key => $tag) {
            $tags[$key] = trimData(mb_strtolower($tag));
        }
        foreach ($this->_rules['no_tag'] as $find => $ifNotFind) {
            if (!in_array($find, $tags)) {
                $result[] = $ifNotFind;
            }
        }
        foreach ($tags as $tag) {
            $flag = false;
            $searchTag = $tag;
            do {
                $finded = false;
                foreach ($this->_rules['append'] as $rootTag => $rulesTags) {
                    if (in_array($searchTag, $rulesTags)) {
                        $finded = true;
                        $result[] = $rootTag;
                        $searchTag = $rootTag;
                        break;
                    }
                }
                if (!$finded) {
                    $flag = true;
                }
            } while ($flag === false);
        }
        foreach ($this->_rules['not_compatible'] as $notCompatibleTags) {
            $check = array_intersect($notCompatibleTags, $result);
            if ($check === $notCompatibleTags) {
                throw new \Exception('Несовместимые теги ' . print_r($notCompatibleTags, true));
            }
        }
        return array_unique($result);
    }

}
