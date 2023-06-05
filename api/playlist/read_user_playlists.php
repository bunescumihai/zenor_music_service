<?php
    session_start();
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=UTF-8');


    if(!isset($_SESSION['id'])){
        http_response_code(400);
        echo json_encode(array("message" => "You are not logged"));
        die();
    }

    include_once '../entity/song.class.php';
    include_once '../config/database.class.php';

    $database = new Database();
    $db =  $database->getConnection();

    $sql = "Select * from `playlist` where user_id = " . $_SESSION['id'];

    $stmt = $db->prepare($sql);
    $stmt->execute();

    $results = array();
    $results['results'] = array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $item = array();
        $item['plid'] = $row['id'];
        $item['name'] = $row['name'];
        array_push($results['results'], $item);
    }

    echo json_encode($results);

?>