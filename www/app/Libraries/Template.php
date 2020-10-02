<?php

namespace App\Libraries;

class Template
{
    /**
     * @param $view
     * @param array $data
     * @return array|mixed|string
     * @throws \Throwable
     */
    public function loadView($view, $data = array())
    {
        return view($view, $data)->render();
    }
}