<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=UTF-8');
    header('Access-Control-Allow-Methods: DELETE');

    session_start();

    if(!isset($_SESSION['id'])){
        http_response_code(400);
        echo json_encode(array("message" => "You are not logged"));
        die();
    }

    include_once '../config/database.class.php';
    include_once '../entity/history.class.php';

    $data = json_decode(file_get_contents("php://input"));

    $database = new Database();
    $db = $database->getConnection();

    $his = new History($db);

    $his->setId($data->hid);

    $stmt = $his->delFromHis();

    if($stmt->execute()){
        http_response_code(200);
        json_encode(array('message' => 'La chanson a ete effacee d\'histoire'));
    }
    else{
        http_response_code(500);
        json_encode(array('message' => 'Error'));
    }

?>