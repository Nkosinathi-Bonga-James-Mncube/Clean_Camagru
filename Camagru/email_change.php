<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <h1>New Email address</h1>
    <form action="" method="post">
        <h2>email<input type="text" name="old_email" placeholder="email"></h2>
        <h2>new email<input type="text" name="new_email1" placeholder="password"></h2>
        <h3>re-enter email<input type="text" name="new_email2" placeholder="re-enter password"></h3>
        <button type="submit" name="new_email">Change email</button>
    </form>
    <a href = 'http://localhost:8080/Camagru/login.php'>Login-in</a>
</body>
</html>
<?php
$email1= htmlspecialchars(strip_tags(trim($_POST['old_email'])));
$new_email1 = htmlspecialchars(strip_tags(trim($_POST['new_email1'])));
$new_email2 = htmlspecialchars(strip_tags(trim($_POST['new_email2'])));

if (isset($_POST['new_email']))
{
    include "config/database.php";
    include "config/setup.php";
    include "error_input_check.php";
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
    $sql10 = 'SELECT * FROM table1 WHERE email = ?';
    $stmt = $pdo->prepare($sql10);
    $stmt->execute([$email1]);
    $post = $stmt->fetchAll();
    
    foreach($post as $post)
    {
        $email_found2 = $post->email;
        $name_found = $post->username;
    }
    if ( (filter_var($new_email1,FILTER_VALIDATE_EMAIL)|| filter_var($new_email2,FILTER_VALIDATE_EMAIL))&& ($new_email1 == $new_email2) && ($email_found2 == $email1) && search_dup_new_name($new_email1,NULL) == NULL)
    {
        $sql2 ='UPDATE table1 SET email = :email WHERE username = :username';
        $stmt1 = $pdo->prepare($sql2);
        $stmt1->execute(['email'=>$new_email1,'username' => $name_found]);
        echo ("Email changed");
    }
    else
    {
        echo("Possbile issues :". "<br>");
        echo ("1.New email address do not match. Please re-enter"."<br>");
        echo ("2.Old Email is incorrect/doesnt exist.Please re-enter"."<br>");
        echo ("3.Email address has already been taken.Please re-enter"."<br>");
        echo ("4.Email address is invaid format.Please re-enter"."<br>");
    }
}


?>