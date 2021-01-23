<?php
function search_dup($enter_email,$enter_user)
{
    include ".././config/database.php";
    include_once ".././config/connection.php";
    
    try {
        // echo realpath('.././config/database.php');
        $pdo = DB_Connection( $DB_DSN, $DB_NAME, $DB_USER, $DB_PASSWORD);
        $bfound = NULL;

        $sql4 = "SELECT * FROM table1 WHERE email = :email OR username = :username";
        $stmt = $pdo->prepare($sql4);
        $stmt->execute(['email'=>$enter_email,'username'=>$enter_user]);
        $post = $stmt->fetchAll();
        foreach($post as $post)
        {
            $e_found = $post['email'];
            $n_found = $post['username'];
        }
        if ($enter_email == isset($e_found) | $enter_user == isset($n_found))
        {
            echo("User already exist. Please enter another username or email address");
            echo realpath('../pages');
            $bfound ="Found";
        }
    }
    catch (PDOException $ex) {
            echo "ERROR: could add table to database: " . $ex->getMessage(); 

    }
    return ($bfound);
}
?>