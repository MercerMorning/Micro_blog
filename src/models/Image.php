<?php

namespace App\Models;

class Image extends Base
{
    /**
     * Добавление картинки к сообщению
     * @param $file
     */
    public function add($file)
    {
        if (!file_exists($file)) {
            return 0;
        }
        $sql = "SELECT id FROM `micro_blog_messages` WHERE isset_image = 1 ORDER BY id DESC";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        return move_uploaded_file ($file, PROJECT_PATH . "/public_html/images/" . $result["id"] . ".jpg");
    }
}