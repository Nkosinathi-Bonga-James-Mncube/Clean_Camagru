<?php function get_update()//likes
{
    include ".././config/database.php";
    include_once ".././config/connection.php";


    $pdo = DB_Connection( $DB_DSN, $DB_NAME, $DB_USER, $DB_PASSWORD);

    $sql3 = $pdo->prepare("INSERT INTO Likes(likes,name_img,verf_code) VALUES (:likes,:name_img,:verf_code)") ;
    $sql3->execute(['likes'=>'1','name_img'=>$_GET['i'],'verf_code'=>$_SESSION['verf_no']]);

    $sql = 'SELECT * FROM Likes WHERE name_img = :name_img AND verf_code = :verf_code';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['name_img'=>$_GET['i'] ,'verf_code'=>$_SESSION['verf_no']]);
    $count=$stmt->rowCount();
    
    if ($count !=1)
    {
        $sql2='DELETE FROM Likes WHERE verf_code = :verf_code AND name_img = :name_img LIMIT 1';
        $stmt1 = $pdo->prepare($sql2);
        $stmt1->execute(['name_img' => $_GET['i'],'verf_code'=>$_SESSION['verf_no']]);
    }
        // // $sql2 ='UPDATE Likes SET flag = :flag,likes = :likes WHERE name_img = :name_img AND verf_code= :verf_code';
        // // $stmt1 = $pdo->prepare($sql2);
        // if ($like_value == '0')
        // {
        //     $sql2 ='UPDATE Likes SET flag = :flag,likes = :likes WHERE name_img = :name_img AND verf_code= :verf_code';
        //     $stmt1 = $pdo->prepare($sql2);
        //     $stmt1->execute(['flag'=>'1','likes' =>'1','name_img' => $_GET['i'],'verf_code'=>$_SESSION['verf_no']]);
        // }

}



function unlikes()
{

        include ".././config/database.php";
        include_once ".././config/connection.php";

        $pdo = DB_Connection( $DB_DSN, $DB_NAME, $DB_USER, $DB_PASSWORD);
        echo "in 2 place";
        $sql2='DELETE FROM Likes WHERE verf_code = :verf_code AND name_img = :name_img';
        // $sql2 ='UPDATE Likes SET flag = :flag,likes = :likes WHERE name_img = :name_img AND verf_code= :verf_code';
        $stmt1 = $pdo->prepare($sql2);
        $stmt1->execute(['name_img' => $_GET['i'],'verf_code'=>$_SESSION['verf_no']]);
        // $stmt1->execute(['flag'=>'0','likes' =>'0','name_img' => $_GET['i'],'verf_code'=>$_SESSION['verf_no']]);

}




function get_likes()
{
    $value = $_GET['i'];
    include ".././config/database.php";
    include_once ".././config/connection.php";

    $pdo = DB_Connection( $DB_DSN, $DB_NAME, $DB_USER, $DB_PASSWORD);
    $sql = 'SELECT * FROM Likes WHERE name_img = :name_img';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['name_img'=>$value]);
    $count=$stmt->rowCount();
    echo "<br><i class='fa fa-thumbs-o-up' aria-hidden='true'></i> Total likes: ".$count."<br>";
    $post= $stmt->fetchAll();
    $n_l = NULL;//maybe its this??
    foreach($post as $post)
    {
        $n_l = $post['likes'];
    }
    if ($n_l == NULL)
        return (0);
    return($n_l);
}

function get_verf()//for likes!
{
    $value = isset($_GET['i']);//maybe its this?
    include ".././config/database.php";
    include_once ".././config/connection.php";
    $pdo = DB_Connection( $DB_DSN, $DB_NAME, $DB_USER, $DB_PASSWORD);
    $sql = 'SELECT * FROM Likes WHERE verf_code = :verf_code AND name_img = :name_img';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['verf_code'=>$_SESSION['verf_no'] , 'name_img'=>$_GET['i']]);
    $post= $stmt->fetchAll();
    $verf_l = NULL;
    foreach($post as $post)
    {
        $verf_l = $post['flag'];
    }
    return($verf_l);
}

function like_pressed()
{
    // $like_results =get_likes();
    if (isset($_POST['likes']))
    {
        // $flag_results =  get_verf();
        get_update();
        // sleep(4);
        // get_update($like_results);
        // echo "<script>window.location.href='./image_details.php?i='.{$_GET['i']}.'</script>";
        // return (1);
    }
    if (isset($_POST['unlikes']))
    {
        unlikes();
        // sleep(4);
        // unlikes($like_results);
        // echo "<script>window.location.href='./image_details.php?i='.{$_GET['i']}.'</script>";
        // return (1);
        exit(header("Location: http://localhost:8080/Camagru/SETA_Camagru/pages/image_details.php?i={$_GET['i']}"));
        unset($_POST);
    }
    

    // echo '<script>window.location.href="./image_details.php?i='.$_GET['i'].';</script>';
    // exit(header("Location: http://localhost:8080/Camagru/SETA_Camagru/pages/image_details.php?i={$_GET['i']}"));
    // header("Location: http://localhost:8080/Camagru/SETA_Camagru/pages/image_details.php?");
    
}
