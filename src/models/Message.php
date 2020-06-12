<?php

namespace App\Models;

class Message extends Base
{

    /**
     * Получение всех сообщений
     * @return array
     */
    public function getAllMessages()
    {
        $sql = "SELECT micro_blog_messages.id, text, date, name FROM micro_blog_messages INNER JOIN micro_blog ON micro_blog.id = micro_blog_messages.user_id ORDER BY id DESC LIMIT 3";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Добавление картинки к сообщению
     * @param $file
     */
    public function setImageToMessage($file)
    {
        $fileContent = file_get_contents($file);
        $res = file_put_contents(PROJECT_PATH . "/images/" . $this->getLastInsertID() . ".jpg", $fileContent);
        return $res;
    }

    /**
     * Получение последнего добавленного id
     * @return mixed
     */
    public function getLastInsertID()
    {
        $sql = "SELECT id FROM `micro_blog_messages` ORDER BY id DESC LIMIT 1";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute();
        return $statement->fetch(\PDO::FETCH_ASSOC)["id"];
    }

    /**
     * Добавление сообщения
     * @param $user
     * @param $text
     * @return bool
     */
    public function addMessage($user, $text)
    {
        $sql = "INSERT INTO `micro_blog_messages` (text, `date`, user_id) VALUES (:text, :date, :user_id)";
        $statement = $this->getConnect()->prepare($sql);
        $ret = $statement->execute(["text" => $text,
            "date" => date("y.m.d"),
            "user_id" => $user["id"]
        ]);
        return $ret;
    }

    /**
     * Удаление сообщения
     * @param $id
     */
    public function deleteMessage($id)
    {
        $sql = "DELETE FROM micro_blog_messages WHERE id=:id";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute(["id" => $id]);
        return $statement->rowCount();
    }

    /**
     * Получение массива со всеми сообщениями пользователя с определенным id в json формате
     * @param $id
     * @return false|string
     */
    public function getAllMessagesById($id)
    {
        $sql = "SELECT text FROM `micro_blog_messages` WHERE user_id=:user_id";
        $statement = $this->getConnect()->prepare($sql);
        $ret = $statement->execute(["user_id" => $id]);
        return json_encode($statement->fetchAll(\PDO::FETCH_ASSOC));
    }
}