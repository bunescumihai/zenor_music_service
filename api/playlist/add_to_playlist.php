<?php

    session_start();

    if(!isset($_SESSION['id'])){
        http_response_code(400);
        echo json_encode(array("message" => "You are not logged"));
        die();
    }

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=UTF-8');
    header('Access-Control-Allow-Methods: GET');

    include_once '../config/database.class.php';
    include_once '../entity/playlist.class.php';

    $database = new Database();
    $db = $database->getConnection();

    $playlist = new Playlist($db);

    if(!empty($_GET['id']) && !empty($_GET['musicId'])){

        $playlist->setId($_GET['id']);
        $playlist->setMusicId($_GET['musicId']);

        $stmt = $playlist->addToPlaylist();

        if($stmt->execute()){
            http_response_code(200);
            echo json_encode(array('message' => 'La chanson a ete ajoutee avec succes'));
        }
        else{
            http_response_code(500);
            echo json_encode(array('message' => 'Error'));

        }

    }
    else{
        http_response_code(400);
        echo json_encode(array('message' => 'Bad Request'));
    }

    ?>