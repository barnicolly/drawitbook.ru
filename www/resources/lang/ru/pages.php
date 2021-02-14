<?php

return [
    'errors_alt' => 'Произошла ошибка',
    'main' => [
        'hello' => ' <p>
                    На сайте собрано около <strong>2&nbsp;700 рисунков по клеточкам</strong>.
                </p>
                <p>
                    Воспользуйтесь поиском по сайту или <a href="#tag-list">облаком тегов</a> чтобы найти что-то конкретное.
                </p>
                <p>
                    Голосуйте за понравившиеся рисунки и делитесь с друзьями.
                </p>',
    ],
    '404' => [
        'h1' => 'СТРАНИЦА НЕ НАЙДЕНА ИЛИ БЫЛА УДАЛЕНА',
        'subtitle' => 'Вы обратились к странице «:url».',
        'suggests' => '<p>
            К сожалению, страница не найдена или была удалена. Чтобы найти нужную страницу:
        </p>
        <ul>
            <li>
                проверьте правильность ссылки (если копировали вручную);
            </li>
            <li>
                воспользуйтесь навигацией по сайту.
            </li>
        </ul>',
    ],
    '500' => [
        'h1' => 'Произошла ошибка на стороне сервера.',
        'subtitle' => 'Наши специалисты уже работают над ее устранением.',
    ],
    'search' => [
        'popular_arts' => 'Популярные рисунки',
        'vote_liked' => 'Голосуйте за понравившиеся рисунки и делитесь с друзьями.',
        'h1_by_query' => 'Результаты поиска по запросу «:Query»',
        'img_not_found_alt' => 'По запросу ничего не найдено',
        'not_found_results_title' => 'К сожалению, результатов по запросу не найдено.',
        'suggest' => 'Проверьте правильность ввода, попробуйте уменьшить количество слов.',
        'popular_tags' => 'Популярные #тэги',
    ],
    'pixel_arts' => [
        'index' => [
            'h1' => __('common.pixel_arts'),
            'seo_text' => ' <p>
                Рисовать по клеточкам любит практически каждый ребенок и взрослый. Это очень легко, ведь для этого нужна
                только тетрадь в клеточку. <strong>Рисунки по клеточкам</strong>
                от легких и простых до сложных схем.
                Рисунки подобраны не только для деток 4-5 лет, и 6-7, и 8-9-10 лет, но и для взрослых.
            </p>
            <p>
                Голосуйте за понравившиеся рисунки и делитесь с друзьями.
            </p>',
        ],
        'landing' => [
            'h1' => __('common.pixel_arts') . ' «:TAG»',
            'seo_text_begin' => '<p>Рисовать по клеточкам любит практически каждый ребенок и взрослый. Это очень легко, ведь для этого нужна
            только тетрадь в клеточку. <strong>Рисунки по клеточкам на тему «:Tag»</strong>
            от легких и простых до сложных схем.
            Рисунки подобраны не только для деток 4-5 лет, и 6-7, и 8-9-10 лет, но и для взрослых.
        </p>',
            'seo_text_end' => '<p>
        Если вы хотите сделать креативную открытку своими руками или заполнить дневник оригинальными
        рисунками,
        можно освоить рисование по клеточкам. Картинки по клеточкам - это просто. Хотите научиться классно
        рисовать? Начните с самого простого — с картинок по клеточкам.
        Для это нужна лишь бумага под рукой, да ручка, либо обычный карандаш.
    </p>',
        ],
    ],
    'layout' => [
        'footer' => [
            'copyright' => 'Приветствуется копирование и распространение материалов.',
            'slogan' => 'ЛЮБИТЕ РИСОВАТЬ? МЫ ТОЖЕ.',
            'switch_lang' => 'Переключить язык',
        ],
        'header' => [
            'search' => [
                'placeholder' => 'Поиск по сайту',
            ],
            'menu' => [
                'home' => 'Главная',
                'categories' => 'Категории',
            ],
        ],
    ],
];