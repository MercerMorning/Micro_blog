<?php
$allMesages = $data;
?>

<form enctype="multipart/form-data" action="message" method="post">
    <label for="text"><b>Message</b></label>
    <input type="text" placeholder="Enter Text" name="text" required>
    <input name="userfile" type="file"/><br>
    <button type="submit" class="registerbtn">Send</button>
</form>

<form action="message" method="GET">
    <ul>
        <? foreach ($allMesages as $message => $inf): ?>
            <li>
                <input name="<?= $inf["id"] ?>" type="submit" value="Удалить">
                <pre><?= strip_tags($inf["text"]) ?></pre>
                <pre><?= $inf["date"] ?></pre>
                <pre><?= $inf["name"] ?></pre>
                <?php var_dump(file_exists(PROJECT_PATH . "/images/" . $inf["id"] . ".jpg")); ?>
                <? if (file_exists(PROJECT_PATH . "/images/" . $inf["id"] . ".jpg")): ?>
                    <img src="<?= PROJECT_PATH . "/images/" . $inf["id"] . ".jpg" ?>" alt="image">
                <? endif; ?>
            </li>
        <? endforeach; ?>
    </ul>
</form>

<style>
    li {
        border: 1px solid black;
        display: flex;
        flex-direction: column;
    }
</style>