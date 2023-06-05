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

    include_once '../config/database.class.php';
    include_once '../entity/history.class.php';

    $database = new Database();
    $db = $database->getConnection();

    $history = new History($db);

    $history->setUserId(intval($_SESSION['id']));
    $history->setMusicId(intval($_GET['sid']));

    date_default_timezone_set("Europe/Chisinau");

    $history->setDateAndTime(date("Y-m-d H:i:s"));

    $stmt = $history->addToHis();

    if($stmt->execute()){
        http_response_code(200);
        echo json_encode(array("message" => "OK"));
    }
    else{
        http_response_code(500);
        echo json_encode(array("message" => "Request Error"));
    }
?>