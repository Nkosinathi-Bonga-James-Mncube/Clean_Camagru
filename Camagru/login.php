<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <h1>Login</h1>
    <form action="" method="post">
        <h3>username<input type="text" name="login_user" placeholder="username"></h3>
        <h2>password<input type="password" name="login_pass" placeholder="password"></h2>
        <button type="submit" name="login_sub">Login</button>
    </form>
    <a href = 'http://localhost:8080/Camagru/Signup.php'>Sign-up</a>
    <br>
    <a href = 'http://localhost:8080/Camagru/forgot.php'>Forgot password</a>
</body>
</html>
<?php
if (isset($_POST['login_sub']))
{
    include "config/database.php";
    include "config/setup.php";
    $login_user =$_POST['login_user'];
    $login_pass =$_POST['login_pass'];
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
    $sql7 = 'SELECT * FROM table1 WHERE username = ?';
    $stmt = $pdo->prepare($sql7);
    $stmt->execute([$login_user]);
    $post = $stmt->fetchAll();
    //var_dump($post);
    foreach($post as $post)
    {
        $p_found = $post->pass;
        $is_valid = $post->valid;
        $vkey = $post->verf;
    }
    if (!$p_found)
    {
        echo("User is not present");
    }
    if (password_verify($login_pass,$p_found) && $p_found)
    {
        if ($is_valid == 1)
        {
            $test1 = "hello";
            //echo ("valid user");n 
            header("Location: http://localhost:8080/Camagru/main.php?vkey=$vkey");
        
       }
      else
        {
            echo ("Please check verification email//send link again");
        }
    }
    else if ($p_found)
    {
        echo ("Incorrect.Please check username and password");
    }
}

?>