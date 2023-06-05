<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=UTF-8');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Max-Age: 3600');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

    include_once '../config/database.class.php';
    include_once '../entity/song.class.php';

    $database = new Database();
    $db = $database->getConnection();

    $song = new Song($db);

    $data = json_decode(file_get_contents('php://input'));

    if(
        !empty($data->name) &&
        !empty($data->added_by_user_id) &&
        !empty($data->artist) &&
        !empty($data->src)
    ){
        $song->setAddedByUserId($data->added_by_user_id);
        $song->setName($data->name);
        $song->setArtist($data->artist);
        $song->setSrc($data->src);
        $song->setLyrics(!empty($data->lyrics)? $data->lyrics : null);
        $song->setAlbumId(!empty($data->album_id)? $data->album_id : 0);
        $song->setIsrc(!empty($data->isrc)? $data->isrc : 'img/imag.png');
        $song->setCountryId(!empty($data->country_id)? $data->country_id : null);
        $song->setMusicalGenreId(!empty($data->musical_genre_id)? $data->musical_genre_id : null);

        if($song->create()){
            http_response_code(201);

            echo json_encode(array("message" => "Song was added"));
        }
        else{

            http_response_code(503);

            echo json_encode(array("message" => "Unable to add song."));
        }
    }
    else{

        // set response code - 400 bad request
        http_response_code(400);

        // tell the user
        echo json_encode(array("message" => "Unable to add song. Data is incomplete."));
    }
?>