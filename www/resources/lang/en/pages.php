<?php

return [
    'errors_alt' => 'Error',
    '404' => [
        'h1' => 'PAGE NOT FOUND OR HAS BEEN DELETED',
        'subtitle' => 'You have try visit the page «:url».',
        'suggests' => '<p>
            Sorry, this page was not found or has been deleted. You can try:
        </p>
        <ul>
            <li>
                checking link (if copied manually);
            </li>
            <li>
                using site navigation.
            </li>
        </ul>',
    ],
    '500' => [
        'h1' => 'A server side error has occurred.',
        'subtitle' => 'Our specialists are already working to fix it.',
    ],
    'main' => [
        'hello' => ' <p>
                    Near <strong>2&nbsp;700 pixel arts</strong> collected on the site.
                </p>
                <p>
                    You can use site search or <a href="#tag-list">tags cloud</a> to find something specific.
                </p>
                <p>
                    Vote for the pictures you like and share them with your friends.
                </p>',
    ],
    'search' => [
        'popular_arts' => 'Popular arts',
        'vote_liked' => 'Vote for the pictures you like and share them with your friends.',
        'h1_by_query' => 'Search results by query «:Query»',
        'img_not_found_alt' => 'No search results',
        'not_found_results_title' => 'Sorry, no results were found for your query.',
        'suggest' => 'Check is your typing correctly and try reduce the word count.',
        'popular_tags' => 'Popular tags',
    ],
    'pixel_arts' => [
        'index' => [
            'h1' => __('common.pixel_arts'),
            'seo_text' => ' <p>
                Almost every child and adult loves to draw by pixels. It is very easy, because it requires
                only a notebook with cells. From easy and simple to difficult <strong>Pixel arts</strong> schemes you may find in website.
                Arts are approach not only for children 4-5 years old, and 6-7, and 8-9-10 years old, but also approach for adults.
            </p>
            <p>
                Vote for the pictures you like and share with your friends.
            </p>',
        ],
        'landing' => [
            'h1' => __('common.pixel_arts') . ' «:TAG»',
            'seo_text_begin' => '<p>Almost every child and adult loves to draw by pixels. It is very easy, because it requires
                only a notebook with cells. From easy and simple to difficult <strong>Pixel arts «:Tag»</strong> schemes you may find in website.
                Arts are approach not only for children 4-5 years old, and 6-7, and 8-9-10 years old, but also approach for adults.
        </p>',
            'seo_text_end' => '<p>
If you want to make a creative postcard with your own hands or fill the diary with original arts, you can master
 drawing by pixels. Pictures by pixels are easy.
 Want to learn how to draw cool? Start with the simplest thing - with pictures by pixels.
 For this you need only paper at hand and a pen or an ordinary pencil.
    </p>',
        ],
    ],
    'layout' => [
        'footer' => [
            'copyright' => 'Copying and distribution of materials is encouraged.',
            'slogan' => 'LOVE ART? WE DO TOO.',
        ],
        'header' => [
            'search' => [
                'placeholder' => 'Search',
            ],
            'menu' => [
                'home' => 'home',
                'categories' => 'categories',
            ],
        ],
    ],
];
