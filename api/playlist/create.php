<?php
    session_start();

    if(!isset($_SESSION['id'])){
        http_response_code(400);
        echo json_encode(array("message" => "You are not logged"));
        die();
    }

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=UTF-8');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Max-Age: 3600');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

    include_once '../entity/playlist.class.php';
    include_once '../config/database.class.php';


    $data = json_decode(file_get_contents("php://input"));

    $database = new Database();
    $db = $database->getConnection();

    $pl = new Playlist($db);

    $pl->setName($data->name);
    $pl->setUserId($_SESSION['id']);

    $stmt = $pl->createAPlaylist();

    if($stmt->execute()){
        http_response_code(200);
        echo json_encode(array('message' => 'Le playlist a ete cree'));
    } else{
        http_response_code(500);
        echo json_encode(array('message' => 'Error'));
    }
?>