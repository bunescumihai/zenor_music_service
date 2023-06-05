<?php
    include_once 'connect_db.php';
    $email = $_POST['email'];
    $password = $_POST['password'];
    $tell_number = $_POST['tell_number'];
    $country_id = $_POST['countries'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $nick_name = $_POST['nick_name'];
    $usage = $_POST['usage'];
    $hash_password = password_hash($password, PASSWORD_DEFAULT);
    echo '<br>email:'.$email.
        '<br>password:'.$password.
        '<br>tell_number:'.$tell_number.
        '<br>country:'.$country_id.
        '<br>first_name:'.$first_name.
        '<br>last_name:'.$last_name.
        '<br>nick_name:'.$nick_name.
        '<br>usage:'.$usage.
        '<br>hashpassword:'.$hash_password;


    $sql = 'Insert into users values (NULL, :email, :passwd, :tell_number, :c_id, :fn, :ln, :nn)';
    $values = [':email' => $email, ':passwd' => $hash_password, ':tell_number' => $tell_number, ':c_id' => $country_id, ':fn' => $first_name, ':ln' => $last_name, ':nn' => $nick_name];

    try
    {
        $res = $dbh->prepare($sql);
        $res->execute($values);
        header("Location: ../profil.php");
    }
    catch (PDOException $e)
    {
        /* Query error. */
        echo '<br>Query error.';
        die();
    }

    $dbh = null;
    ?>