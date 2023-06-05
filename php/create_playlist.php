<?php
    session_start();

    if(!isset($_SESSION['id'])){
        header('Location: ../index.php');
        die();
    }

    include_once('connect_db.php');

    $user_id = $_SESSION['id'];
    $playlist_name = $_POST['name'];


    $sql = "INSERT INTO `playlist` (`name`, `user_id`) VALUES ('".$playlist_name."', ".$user_id.")";
    echo $sql;

    try
    {
        $dbh->exec($sql);
        header('Location: ../profil.php');
    }
    catch (PDOException $e)
    {
        /* Query error. */
        echo '<br>Query error.';
        die();
    }
?>
