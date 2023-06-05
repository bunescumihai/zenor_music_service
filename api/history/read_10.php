<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=UTF-8');
    header('Access-Control-Allow-Methods: GET');

    session_start();

    if(!isset($_SESSION['id'])){
        http_response_code(400);
        echo json_encode(array("message" => "You are not logged"));
        die();
    }

    $userId = intval($_SESSION['id']);

    include_once '../config/database.class.php';
    include_once '../entity/history.class.php';
    include_once '../entity/song.class.php';


    $database = new Database();
    $db = $database->getConnection();

    $history = new History($db);
    $song = new Song($db);

    $lim = $_GET['lim'];

    $stmt = $history->read10($userId, $lim);


    $music_arr = array();
    $music_arr['results'] = array();

    if($stmt->execute()){
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $item = $song->getArr($row);
            $item['hid'] = $row['hid'];
            array_push($music_arr['results'], $item);
        }

        http_response_code(200);
        echo json_encode($music_arr);
    }
    else{
        http_response_code(400);
        echo json_encode(array("message" => "Bad request"));
    }


?>