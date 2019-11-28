<?php
session_start();
if (!$_SESSION['verf_no'])
{
    header("Location: localhost:8080/Camagru/index.php");
}

?>
<html>
<head>
    <link rel = "stylesheet" type = "text/css" href = "css/tabs.css">
    <link rel = "stylesheet" type = "text/css" href = "css/login.css">
</head>
<body>
<nav>
<ul>

<li><a href="main.php">Back to main</a></li>
<li><a href="new_email.php">Change Email</a></li>
<li><a href="upload.php">Upload images</a></li>
<li><a href="grid.php">Gallery Edit page</a></li>
<li><a href="logout.php">Log-out</a></li>


</ul>
</nav>
    <h1>Change Username</h1>
    <form action="" method="post">
        <h2>username<input type="text" name="old_user" placeholder="email"></h2>
        <h2>new username<input type="text" name="new_user1" placeholder="password"></h2>
        <h3>re-enter username<input type="text" name="new_user2" placeholder="re-enter password"></h3>
        <button type="submit" name="new_user">Change username</button>
    </form>
  
</body>
</html>
<?php
include "config/database.php";
include_once "config/connection.php";
include "error_input_check.php";

$pdo = DB_Connection( $DB_DSN, $DB_NAME, $DB_USER, $DB_PASSWORD);
if (isset($_POST['new_user']))
{
    $old_user = htmlspecialchars(strip_tags(trim($_POST['old_user'])));
    $new_user1 = htmlspecialchars(strip_tags(trim($_POST['new_user1'])));
    $new_user2 = htmlspecialchars(strip_tags(trim($_POST['new_user2'])));
    $username_found = NULL;

    $sql1 = 'SELECT * FROM table1 WHERE username = ?';
    $stmt = $pdo->prepare($sql1);
    $stmt->execute([$old_user]);
    $post = $stmt->fetchAll();
    foreach($post as $post)
    {
        
        $username_found = $post['username'];
        $email_found = $post['email'];
    }
   
    if (($new_user1 == $new_user2) && ($username_found == $old_user) && search_dup_new_name(NULL,$new_user1) == NULL)
    {   
        include "config/database.php";
        include_once "config/connection.php";
        $pdo = DB_Connection( $DB_DSN, $DB_NAME, $DB_USER, $DB_PASSWORD);
        
        $sql2 ='UPDATE table1 SET username = :username WHERE email = :email';
        $stmt1 = $pdo->prepare($sql2);
        $stmt1->execute(['email'=>$email_found,'username' => $new_user1]);
        echo ("Username is changed");
    }
    else
    {
        echo("Possbile issues :". "<br>");
        echo ("1.New usernames do not match. Please re-enter"."<br>");
        echo ("2.Old username is incorrect/doesnt exist.Please re-enter"."<br>");
        echo ("2.Username has already been taken.Please re-enter"."<br>");
    }
}