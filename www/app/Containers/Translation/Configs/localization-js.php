<?php

declare(strict_types=1);

return [
    /*
     * Set the names of files you want to add to generated javascript.
     * Otherwise all the files will be included.
     *
     * 'messages' => [
     *     'validation',
     *     'forum/thread',
     * ],
     */
    'messages' => [
        'js',
    ],

    // The default path to use for the generated javascript.
    'path' => resource_path('static/lang/translations.js'),
];
