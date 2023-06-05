<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: access');
    header('Access-Control-Allow-Methods: GET');
    header("Access-Control-Allow-Credentials: true");
    header('Content-Type: application/json');

    include_once '../config/database.class.php';

    $database = new Database();
    $db = $database->getConnection();


    if(isset($_GET['search'])){
        $sql = 'Select `id`, `name`, `artist` from music where name like \'%'.$_GET['search'].'%\' or artist like \'%'.$_GET['search'].'%\'';
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $allResults = array();
        $allResults['results'] = array();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $item = array(
                "id" => $row['id'],
                "name" => $row['name'],
                "artist" => $row['artist'],
            );
            array_push($allResults['results'], $item);
        }

        echo json_encode($allResults);
    }
?>