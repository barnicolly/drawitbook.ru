<?php

function route($name, $parameters = [], $absolute = true, $lang = null)
{
    /*
    * Remember the ajax routes we wanted to exclude from our lang system?
    * Check if the name provided to the function is the one you want to
    * exclude. If it is we will just use the original implementation.
    **/
//    if (Str::contains($name, ['ajax', 'autocomplete'])) {
//        return app('url')->route($name, $parameters, $absolute);
//    }

//Check if $lang is valid and make a route to chosen lang
    if ($lang && in_array($lang, config('translator.available_locales'))) {
        return app('url')->route($lang . '_' . $name, $parameters, $absolute);
    }

    $locale_prefix = config('app.locale');
    return app('url')->route($locale_prefix . '_' . $name, $parameters, $absolute);
}
