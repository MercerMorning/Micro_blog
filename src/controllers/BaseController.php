<?php

namespace App\Controllers;

use App\Models\Auth;

class BaseController
{

    /**
     * @var Auth
     */
    protected $auth;

    public function __construct()
    {
        $this->auth = new Auth();
    }

    protected function render($template, $data = [])
    {
        extract($data);
        include __DIR__ . '\..\views\\' . $template . '.php';
    }

    protected function redirect($url)
    {
        //CONST base url
        header("Location: http://" . ADDRESS . $url); //
        exit();
    }

}

