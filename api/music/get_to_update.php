<?php
    session_start();

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=UTF-8');

    include_once '../entity/song.class.php';
    include_once '../config/database.class.php';

    $database = new Database();
    $db =  $database->getConnection();

    $sql = "SELECT `id`, `name`, `artist`, `album_id`, `country_id`, `musical_genre_id`, `release`, `lyrics` from `music` where id = " . $_GET['sid'];

    $sqlCountry = "Select `id`, `name` from country";
    $sqlMusicalGenre = "Select `id`, `name` from musical_genre";
    $sqlAlbums = "Select * from album where user_id = 1 or user_id = 0" ;

    $results = new stdClass();
    $song = new stdClass();
    $countries = array();
    $musicalGenres = array();
    $albums = array();


    $stmt = $db->prepare($sql);
    $stmt->execute();
    $songRow = $stmt->fetch(PDO::FETCH_ASSOC);

    $song->name = $songRow['name'];
    $song->id = $songRow['id'];
    $song->artist = $songRow['artist'];
    $song->release = $songRow['release'];
    $song->lyrics = $songRow['lyrics'];

    $sqlaux = "Select `name` from album where id = " . intval($songRow['album_id']);
    $stmt = $db->prepare($sqlaux);
    $stmt->execute();
    $rowaux = $stmt->fetch(PDO::FETCH_ASSOC);
    $song->album = $rowaux['name'];

    $sqlaux = "Select `name` from country where id = " . intval($songRow['country_id']);
    $stmt = $db->prepare($sqlaux);
    $stmt->execute();
    $rowaux = $stmt->fetch(PDO::FETCH_ASSOC);
    $song->country = $rowaux['name'];

    $sqlaux = "Select `name` from musical_genre where id = " . intval($songRow['musical_genre_id']);
    $stmt = $db->prepare($sqlaux);
    $stmt->execute();
    $rowaux = $stmt->fetch(PDO::FETCH_ASSOC);
    $song->musical_genre = $rowaux['name'];

    $results->song = $song;

    $stmt = $db->prepare($sqlCountry);
    $stmt->execute();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $item = array();
        $item['id'] = $row['id'];
        $item['name'] = $row['name'];
        array_push($countries, $item);
    }
    $results->countries = $countries;

    $stmt = $db->prepare($sqlMusicalGenre);
    $stmt->execute();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $item = array();
        $item['id'] = $row['id'];
        $item['name'] = $row['name'];
        array_push($musicalGenres, $item);
    }
    $results->musicalGenres = $musicalGenres;

    $stmt = $db->prepare($sqlAlbums);
    $stmt->execute();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        $item = array();
        $item['id'] = $row['id'];
        $item['name'] = $row['name'];
        $item['artist'] = $row['artist'];
        $item['release_date'] = $row['release_date'];

        array_push($albums, $item);
    }
    $results->albums = $albums;

    echo json_encode($results)

?>
