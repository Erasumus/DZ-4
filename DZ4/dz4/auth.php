<?php
mysql_connect("localhost",'root','') or die("Невозможно подключиться к бд");
mysql_select_db('dz') or die("Невозможно выбрать бд");
session_start();
header("Content-type: text/html; Charset=utf-8");
unset($_SESSION['auth']);

$query="SELECT * FROM users";
$res=mysql_query($query);
$row=array();
while($arr=mysql_fetch_assoc($res)){
$row[]=$arr;
}

if(isset($_POST['submit'])) {
    foreach($row as $item) {
    if ($item['login'] == $_POST['login'] && $item['pass'] == md5($_POST['pass'])) {
        $_SESSION['auth']['login'] = $_POST['login'];
        unset( $_SESSION['error']);
        break;
    } else {
        $_SESSION['error'] = "Данные не совпадают";
    }
}
    if (!$_SESSION['error']) {
        header("Location: http://localhost/dz1/index.php");
        exit();
    }
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

        main {
            display: table;
            background: #fff;
            margin: 30px auto;
            padding: 30px;
        }

        input[type="text"], input[type="password"] {
            display: block;
            margin: 5px 0;
        }

        form > a {
            margin-left: 15px;
            color: #666;
            text-decoration: none;
            font-size: 12px;
        }

        form {
            margin: 0 auto;
            display: table;
        }

        div {
            background: #ff7d98;
            padding: 10px;
            margin-top: 30px;
        }
    </style>
</head>
<body>

<main>
    <h2>Добро пожаловать, гость!</h2>

    <form method="post">
        <input type="text" name="login" placeholder="Логин" value="<?= $_SESSION['user']['login'] ?>" required>
        <input type="password" name="pass" placeholder="Пароль" value="<?= $_SESSION['user']['pass'] ?>" required>
        <input type="submit" name="submit" value="Войти">
        <a href="registr.php">Зарегистрироваться</a>
    </form>

    <?php
    if ($_SESSION['error']) {
        ?>

        <div>
            <?= $_SESSION['error'] ?>
        </div>
    <?php
    }

?>
</main>

</body>
</html>