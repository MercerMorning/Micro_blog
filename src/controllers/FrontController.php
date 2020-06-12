<?php

namespace App\Controllers;

use App\Models\Message;
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
     * Экшен-контроллер главной страницы
     */
    public function index()
    {
        $this->render('front\index');
    }

    /**
     * Экшен-контроллер страницы регистрации
     */
    public function register()
    {
        $error = $this->validationRegisterForm($_POST);
        if ($error) {
            $this->render('front\register', ["error" => $error, "result" => "Register failed"]);
            return 0;
        }
        $userModel = new User();
        $user = $userModel->getUser($_POST["email"]);
        if (!empty($user)) {
            return 0;
        }
        $userModel->addUser($_POST);
        $this->render('front\register', ["error" => $error, "result" => "Register success"]);
    }

    /**
     * Экшен-контроллер страницы входа
     */
    public function login()
    {
        if ($_POST["email"] && $_POST["password"]) {
            $userModel = new User();
            $user = $userModel->getUser($_POST["email"]);
            if (password_verify($_POST["password"], $user["password"]) && $user) {
                $userModel->login($user);
                if (in_array($userModel->user()["id"], ADMIN_ID)) {
                    header("Location: http://hmmvc/admin/message");
                    exit();
                }
                header("Location: http://hmmvc/user/message");
                exit();
            }
        }
        $this->render('front\login', ["log" => "Неверно введен email или пароль"]);
    }

    /**
     * Экшен-контроллер страницы сообщений
     */
    public function message()
    {
        $messageModel = new Message();
        if (!$messageModel->quest()) {
            $message = $messageModel->user();
            $allMessages = $messageModel->getAllMessages();
            $isAddMessage = $messageModel->addMessage($message, $_POST["text"]);
            if (!empty($_FILES["userfile"]["tmp_name"])) {
                $messageModel->setImageToMessage($_FILES["userfile"]["tmp_name"]);
            }
            if ($isAddMessage) {
                header("Location: http://hmmvc/user/message");
                exit();
            }
            $this->render('front\message', $allMessages);
        }
        return 0;
    }
}