<?php
session_start();
header("Content-type: text/html; Charset=utf-8");
if($_POST['exit']==1){
    session_destroy();
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <style>
        body {
            background: #666;
        }

        form {
            padding: 20px;
            display: table;
            margin: 30px auto;
            background: #fff;
        }

        input[type="text"] {
            display: block;
        }

        input[type="number"] {
            width: 30px;
            margin-left: 10px;
        }

        textarea {
            min-width: 200px;
            max-width: 200px;
            max-height: 100px;
            display: block;
            margin-bottom: 20px;
        }

        div {
            width: 353px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
        }

        .redirect {
            color: #666;
            float: right;
            text-decoration: none;;
        }

        .redirect:hover {
            text-decoration: underline;
        }

        #exit {
            display: table;
            color: #666;
            text-decoration: none;
            margin-top: 5px;
            font-size: 14px;
        }

        div > a {
            display: block;
        }

    </style>
</head>
<body>
<?php
if(isset($_SESSION['auth'])){
    ?>
<form method="post">
    <input type="text" name="name" placeholder="Введите ваш логин" value="<?= $_SESSION['auth']['login'] ?>" required>

    <p>Выберите аксессуары и принадлежности PC</p>

    <p><label><input type="checkbox" name="game[]" value="Battlefield3">Мышка</label> - 250руб <label>|
            Количество<input type="number" name="bf3" value="1" min="1" max="5"></label></p>

    <p><label><input type="checkbox" name="game[]" value="Battlefield4">Клавиатура</label> - 150руб <label>|
            Количество<input type="number" name="bf4" value="1" min="1" max="5"></label></p>

    <p><label><input type="checkbox" name="game[]" value="Battlefield:Hardline">Чехол</label> - 50руб
        <label>| Количество<input type="number" name="bfh" value="1" min="1" max="5"></label></p>

    <p><label><input type="checkbox" name="game[]" value="Call of Duty MW">Сканер</label> - 2000руб <label>|
            Количество<input type="number" name="mw" value="1" min="1" max="5"></label></p>

    <p><label><input type="checkbox" name="game[]" value="Call of Duty MW:2">Принтер</label> - 2000руб <label>|
            Количество<input type="number" name="mw2" value="1" min="1" max="5"></label></p>

    <p><label><input type="checkbox" name="game[]" value="Call of Duty MW:3">Монитор</label> - 3000руб <label>|
            Количество<input type="number" name="mw3" value="1" min="1" max="5"></label></p>

    <label>Ваш комментарий:<textarea name="comment"></textarea></label>
    <input type="submit" name="submit" value="Отправить">

        <a href="auth.php?exit=1" class="redirect">Выход с профиля</a>


</form>

<?php

if (isset($_POST['submit'])) {
    $mass['name'] = $_POST['name'];
    ?>
    <div>
        <p>Здравствуйте,<?= $_POST['name'] ?></p>

        <p>Вы заказали:</p>
        <ul>
            <?php
            if (isset($_POST['game'])) {
                $mass['game'] = $_POST['game'];
                $mass['game'] = implode(" | ", $mass['game']);
                foreach ($_POST['game'] as $item) {
                    ?>
                    <li><?= $item ?></li>
                <?php
                }
            } else echo "<p style='color: red;'>Ничего</p>";


            ?>
        </ul>

        <?php
        if (!empty($_POST['comment'])) {
            ?>

            <p>Комментарий:</p>
            <p><?= $_POST['comment'] ?></p>
            <?php
            $mass['comment'] = $_POST['comment'];
        }
        ?>
        <p>Общая цена:</p>
        <?php
        $all_price = 0;
        if (isset($_POST['game']))
            foreach ($_POST['game'] as $price)
                switch ($price) {
                    case('Мышка'):
                        $all_price += 250 * $_POST['msh'];
                        break;

                    case('Клавиатура'):
                        $all_price += 150 * $_POST['klv'];
                        break;

                    case('Чехол'):
                        $all_price += 50 * $_POST['che'];
                        break;

                    case('Сканер'):
                        $all_price += 2000 * $_POST['scn'];
                        break;

                    case('Принтер'):
                        $all_price += 2000 * $_POST['pri'];
                        break;

                    case('Монитор'):
                        $all_price += 3000 * $_POST['mon'];
                        break;
                }
        ?>
        <p><?= $all_price ?></p>
    </div>
    <?php
    $fp = fopen("test.csv", "a+");
    fputcsv($fp, $mass, ';');
    fclose($fp);
}
}

else {
    ?>

    <div style="text-align: center; color: red;">
        Вы не авторизованы
    <a href="auth.php">Авторизация</a>
    </div>

<?php
}



?>

</body>
</html>