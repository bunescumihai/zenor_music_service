<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header("Location: ../index.php");
        die("You are not logged");
    }
    include_once 'connect_db.php';
    include_once '../mp3file.class.php';

    $name = $_POST['name'];
    $artist = $_POST['artist'];
    $time = time();

    if(empty($_FILES['music']['name'])){
        header("Location: ../index.php");
        die("Le chanson n'est pas choisi");
    }

    if(empty($_FILES['image']['name']))
        $image_src = 'img/imag.png';
    else{
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_src = '../img/music/'.$time.'_'.$image_name;
    }

    $music_name = $_FILES['music']['name'];
    $music_tmp = $_FILES['music']['tmp_name'];


    $mp3 = new MP3File($music_tmp);

    $duration = $mp3->getDuration();
    $d = substr(MP3File::formatTime($duration), -5);

    $music_src = 'music/'.$time.'_'.$music_name;

    $sql = "Insert into music values (NULL, :added_by_user_id, :name, :artist, :src, :isrc, :country_id, :musical_genre_id, NULL, :hearings, :likes, :dislikes)";
    $sql2 = "INSERT INTO `music` ( `added_by_user_id`, `name`, `artist`, `src`, `isrc`, `duration`, `country_id`, `musical_genre_id`, `album_id`, `hearings`, `likes`, `dislikes`) 
            VALUES ( :added_by_user_id, :name, :artist, :src, :isrc, :duration, :country_id, :musical_genre_id, :album_id, :hearings, :likes, :dislikes)";

    $values = [
        ':added_by_user_id' => $_SESSION['id'],
        ':name' => $name,
        ':artist' => $artist,
        ':src' => $music_src,
        ':isrc' => $image_src,
        ':duration' => $d,
        ':country_id' => 1,
        ':musical_genre_id' => 1,
        ':album_id' => 1,
        ':hearings' => 0,
        ':likes' => 0,
        ':dislikes' => 0,
    ];
    print_r($values);

    try
    {
        $sth = $dbh->prepare($sql2);
        $sth->execute($values);
    }

    catch (PDOException $e)
    {
        /* Query error. */
        echo '<br>Query error.';
        die();
    }

    if(!empty($_FILES['image']['name']))
        move_uploaded_file($image_tmp, $image_src);

    move_uploaded_file($music_tmp, "../".$music_src);

    header('Location: ../profil.php');
?>