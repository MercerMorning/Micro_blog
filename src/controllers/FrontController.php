<?php

namespace App\Controllers;

use App\Models\User;

class FrontController extends BaseController
{

    /**
     * Валидация регистрационных данных
     * @param array $post
     * @return array
     */
    private function validationRegisterForm(array $post)
    {
        $result = [];
        if (empty($post['name'])) {
            $result[] = 'name is empty';
        }
        if (empty($post['email'])) {
            $result[] = 'email is empty';
        }
        if (empty($post['password'])) {
            $result[] = 'password is empty';
        }
        if (mb_strlen($post['password']) < 4) {
            $result[] = 'password must be more than 4 characters';
        }
        if ($post['password'] !== $post['password-repeat']) {
            $result[] = 'passwords don\'t match';
        }
        return $result;
    }

    /**
     * Главная страница
     */
    public function index()
    {
        $this->render('front\index');
    }

    /**
     * Регистрация
     */
    public function register()
    {
        $error = $this->validationRegisterForm($_POST);
        if ($error) {
            $this->render('front\register', ["error" => $error, "result" => "Register failed"]);
            return 0;
        }
        $userModel = new User();
        $user = $userModel->get($_POST["email"]);
        if (!empty($user)) {
            return 0;
        }
        $userModel->add($_POST);
        $this->render('front\register', ["error" => $error, "result" => "Register success"]);
    }

    /**
     * Вход
     */
    public function login()
    {
        if ($_POST["email"] && $_POST["password"]) {
            $userModel = new User();
            $user = $userModel->get($_POST["email"]);
            if (password_verify($_POST["password"], $user["password"]) && $user) {
                $this->auth->login($user);
                if (in_array($this->auth->user()["id"], ADMIN_ID)) {
                    $this->redirect("message/indexAdmin");
                }
                $this->redirect("message/index");
                exit();
            }
        }
        $this->render('front\login', ["log" => "Неверно введен email или пароль"]);
    }
}