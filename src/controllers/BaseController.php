<?php

namespace App\Controllers;

class BaseController
{
    protected $user;

    protected function render($template, $data = [])
    {
        extract($data);
        include __DIR__ . '\..\views\\' . $template . '.php';
    }
}

