<?php

namespace App\Controllers;

use App\Models\Message;

class AdminController extends BaseController
{
    public function message()
    {
        $messageModel = new Message();
        if (!$messageModel->quest()) {
            $message = $messageModel->user();
            $allMessages = $messageModel->getAllMessages();
            $isAddMessage = $messageModel->addMessage($message, $_POST["text"]);
            $isDelMessage = $messageModel->deleteMessage(key($_GET));
            if (!empty($_FILES["userfile"]["tmp_name"])) {
                $messageModel->setImageToMessage($_FILES["userfile"]["tmp_name"]);
            }
            if ($isAddMessage || $isDelMessage) {
                header("Location: http://hmmvc/admin/message");
            }
            $this->render('front\messageAdmin', $allMessages);
        }
        return 0;
    }

}
