<?php

namespace App\Models;

class Base
{
    const SESSION_INDEX_USER = 'user';

    /**
     * @var \PDO
     */
    protected static $pdo;

    /**
     * Подключение к базе данных
     * @return \PDO
     */
    protected function getConnect()
    {
        if (self::$pdo === null) {
            self::$pdo = new \PDO(
                DSN_DB, USERNAME_DB, PASSWORD_DB
            );
        }
        return self::$pdo;
    }

    /**
     * Получение юзера из сессии
     * @return mixed
     */
    public function user()
    {
        return $_SESSION[self::SESSION_INDEX_USER];
    }

    /**
     * Проверка логина
     * @return bool
     */
    public function quest()
    {
        return empty($_SESSION[self::SESSION_INDEX_USER]);
    }

    /**
     * Установка пользователя в сессию
     * @param array $user
     */
    public function login(array $user)
    {
        $_SESSION[self::SESSION_INDEX_USER] = $user;
    }

    /**
     * Удаление пользователя из сессии
     */
    public function logout()
    {
        $_SESSION[self::SESSION_INDEX_USER] = null;
    }
}