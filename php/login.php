<?php
    session_start();
    include_once 'connect_db.php';
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $sql = "Select id, email, password, first_name, last_name, nick_name from users where email = '".$email."'";

    echo $email.'<br>'.$password.'<br>'.$sql;
    try
    {
        $rs = $dbh->query($sql);
        echo 'trec1';
        $rs = $rs->fetchAll(PDO::FETCH_ASSOC);
        echo 'trec2';
        if($rs && password_verify($password, $rs[0]['password'])){
            $_SESSION['id'] = $rs[0]['id'];
            $_SESSION['email'] = $rs[0]['email'];
            $_SESSION['first_name'] = $rs[0]['first_name'];
            $_SESSION['last_name'] = $rs[0]['last_name'];
            $_SESSION['nick_name'] = $rs[0]['nick_name'];
            $_SESSION['usage'] = $rs[0]['usage'];
            header("Location: ../index.php");
        }
        else{
            header("Location: ../auth.php");
            session_unset();
            session_destroy();
        }
    }
    catch (PDOException $e)
    {
        /* Query error. */
        echo '<br>Query error.';
        die();
    }

$dbh = null;
?>