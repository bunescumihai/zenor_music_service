<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=UTF-8');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Max-Age: 3600');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

    include_once '../config/database.class.php';
    include_once '../entity/song.class.php';

    $database = new Database();
    $db = $database->getConnection();

    $song = new Song($db);

    $data = json_decode(file_get_contents('php://input'));

    $sql = "UPDATE `music` SET 
                   `name` = :name,
                   `artist` = :artist,
                   `lyrics` = :lyrics,
                   `country_id` = :country_id,
                   `album_id` = :album_id,
                   `musical_genre_id` = :genre_id,
                   `release` = :release
               WHERE `music`.`id` = :id";

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':name', $data->name);
    $stmt->bindValue(':artist', $data->artist);
    $stmt->bindValue(':lyrics', $data->lyrics);
    $stmt->bindValue(':country_id', intval($data->country_id));
    $stmt->bindValue(':album_id', intval($data->album_id));
    $stmt->bindValue(':genre_id', intval($data->genre_id));
    $stmt->bindValue(':release', intval($data->release));
    $stmt->bindValue(':id', intval($data->id));

    if($stmt->execute()){
        http_response_code(200);
        echo json_encode(array('message', 'Succes'));
    }
    else {
        http_response_code(500);
        echo json_encode(array('message', 'Error'));
    }
?>