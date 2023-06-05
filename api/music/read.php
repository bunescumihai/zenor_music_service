<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=UTF-8');

    include_once '../entity/song.class.php';
    include_once '../config/database.class.php';

    $database = new Database();
    $db =  $database->getConnection();

    $song = new Song($db);

    if(isset($_GET['lim']) && isset($_GET['stype']) && isset($_GET['count'])){
        $stmt = $song->readBySortTypeAndLimits($_GET['stype'], intval($_GET['lim']), $_GET['count']);
        $music = array();
        $music['records'] = array();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $item = $song->getArr($row);

            array_push($music['records'], $item);
        }

        http_response_code(200);

        echo json_encode($music);
        exit;

    }



    $stmt = $song->read();
    $num = $stmt->rowCount();

    if($num > 0){
        $music = array();
        $music['records'] = array();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $item = $song->getArr($row);

            array_push($music['records'], $item);
        }

        http_response_code(200);

        echo json_encode($music);

    }
    else{
        // set response code - 404 Not found
        http_response_code(404);

        // tell the user no products found
        echo json_encode(
            array("message" => "No products found.")
        );
    }
?>