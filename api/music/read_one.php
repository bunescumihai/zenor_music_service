<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: access');
    header('Access-Control-Allow-Methods: GET');
    header("Access-Control-Allow-Credentials: true");
    header('Content-Type: application/json');

    include_once '../config/database.class.php';
    include_once '../entity/song.class.php';

    $database = new Database();
    $db = $database->getConnection();

    $song = new Song($db);

    if(!isset($_GET['id']) && empty($_GET['id']))
        die();

    $song->setId(intval($_GET['id']));

    $song->readOne();

    if($song->getName() != null){
        $item = array(
            'id' => $song->getId(),
            'name' => $song->getName(),
            'added_by_user_id' => $song->getAddedByUserId(),
            'artist' => $song->getArtist(),
            'src' => $song->getSrc(),
            'isrc' => $song->getIsrc(),
            'duration' => $song->getDuration(),
            'lyrics' => $song->getLyrics(),
            'country_id' => $song->getCountryId(),
            'musical_genre_id' => $song->getMusicalGenreId(),
            'album_id' => $song->getAlbumId(),
            'hearings' => $song->getHearings(),
            'likes' =>  $song->getLikes(),
            'dislikes' => $song->getDislikes()
        );

        http_response_code(200);

        echo json_encode($item);
    }
    else{

        http_response_code(404);

        echo json_encode(array("message"=>"Song does not exist"));
    }
?>