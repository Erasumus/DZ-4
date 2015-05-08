<?php
mysql_connect("localhost",'root','') or die("Невозможно подключиться к бд");
mysql_select_db('dz') or die("Невозможно выбрать бд");
session_start();
header("Content-type: text/html; Charset=utf-8");

if(isset($_POST['submit'])){
    $login=$_SESSION['user']['login']=$_POST['login'];
    $name=$_SESSION['user']['name']=$_POST['name'];
    $pass=$_SESSION['user']['pass']=$_POST['pass'];
    $mail=$_SESSION['user']['email']=$_POST['email'];


    $query = "SELECT id FROM users WHERE login='$login'";
    $res = mysql_query($query);
    $row = mysql_num_rows($res);
    $query2="SELECT id FROM users WHERE mail='$mail'";
    $res2=mysql_query($query2);
    $row2=mysql_num_rows($res2);
    if($row){
        $_SESSION['error'] .='Логин занят'."<br>";
    }
    if($row2){
        $_SESSION['error'] .='EMail занят'."<br>";
    }

    if(!$_SESSION['error']){
        $pass=md5($pass);
        $query3="INSERT INTO users(login,mail,name,pass) VALUES('$login','$mail','$name','$pass')";
        mysql_query($query3);
       header("Location: http://localhost/dz1/auth.php");
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
    <h2>Страница регистрации</h2>
    <form method="post">
        <input type="text" name="login" placeholder="Логин" required>
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="text" name="name" placeholder="Имя" required>
        <input type="password" name="pass" placeholder="Пароль" required>
        <input type="submit" name="submit" value="Зарегистрироваться">
    </form>




    <?php
    if($_SESSION['error']){
        ?>
        <div>
            <?=$_SESSION['error']?>
        </div>
    <?php
    }
    unset($_SESSION['error']);

    ?>
</main>



</body>
</html>