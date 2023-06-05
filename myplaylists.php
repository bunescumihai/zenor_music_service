<!DOCTYPE html>
<?php
    session_start();
    if(!isset($_SESSION['id'])){
        echo '<h1>Vous n\'etes pas authentifie</h1><br>';
        echo '<a href="auth.php">Page d\'auhtentification</a>';
        die();
    }
    include 'php/connect_db.php';
    if (isset($_GET['playlist']) && isset($_GET['name']) && !empty($_GET['name'])) {
        $sql = "UPDATE `playlist` SET `name` = '".$_GET['name']."' WHERE `id` = ".$_GET['playlist'];
        $dbh->exec($sql);
        header("Location: myplaylists.php");
    } elseif(isset($_GET['name']) && !empty($_GET['name'])){
        $sql = "Insert into `playlist` values (NULL, '".$_GET['name']."',1)";
        $dbh->exec($sql);
        header("Location: myplaylists.php");
    }elseif(isset($_GET['effp']) && isset($_GET['effm'])){
        $sql = "DELETE FROM `music_playlist` WHERE `playlist_id` = ".$_GET['effp']." and `music_id` = ".$_GET['effm'];
        $dbh->exec($sql);
        header("Location: myplaylists.php");
    }elseif(isset($_GET['effp'])){
        $sql = "DELETE FROM `music_playlist` WHERE `playlist_id` = ".$_GET['effp'];
        $dbh->exec($sql);
        $sql = "Delete from `playlist` where `id` = ".$_GET['effp'];
        $dbh->exec($sql);
        header("Location: myplaylists.php");
    }elseif(isset($_GET['mid']) && isset($_GET['playlist'])){
        $sql = "Insert into `music_playlist` values (".$_GET['mid'].",".$_GET['playlist'].")";
        $dbh->exec($sql);
        header("Location: myplaylists.php");
}
?>

<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zenor</title>
    <link href="css/bootstrap.css" rel ="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/css.css">
    <link rel="stylesheet" href="css/resp.css">
    <link rel="stylesheet" href="css/playlist.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>
<body>
<?php include "secv/topbar.php"?>
<?php include "secv/header.php"?>
<div id="playlists-container" class="shadow shadow-info shadow-intensity-lg">
    <div id="content"3>
        <h1>Mes Playlists</h1>
        <div id="playlists-menu">
            <button class="playlist-manage" onclick="showCreatePlaylist(this)">
                Creer un playlist
            </button>
            <button class="playlist-manage" onclick="showChangePlaylistName(this)">
                Renommer un playlist
            </button>
        </div>

        <div id="create-playlist" class="action-playlist hidden">
            <h3>Ajouter un playlist</h3>
            <form method="get">
                <input type="text" name="name">
                <input type="submit">
            </form>
        </div>

        <div id="change-playlist-name" class="action-playlist hidden">
            <h3>Changer le nom du playlist</h3>
            <form method="get">
                <select name="playlist" >
                    <?php
                    $sql = "Select * from playlist";
                    $rs = $dbh->query($sql);
                    foreach ($rs->fetchAll() as $row){
                        echo '
                            <option value="'.$row['id'].'">'.$row['name'].'</option>
                        ';
                    }
                    ?>
                </select>
                <input type="text" name="name">
                <input type="submit">
            </form>
        </div>

        <?php
        $sql = "Select * from playlist where user_id = " . $_SESSION['id'];
        $rs = $dbh->query($sql);
        $list  = 1;
        foreach ($rs->fetchAll() as $row){
            echo '
            <div class="playlist" >
                <div class="playlist-info">
                    <div class="playlist-img">
                        <img src="img/imag.png">
                    </div>
                    <div class="playlist-name-and-player">
                        <div class="name">' .$row['name']. '</div>
                    </div>
                    <div class="playlist-operations">
                        <a href="myplaylists.php?effp='.$row['id'].'"><i class="bi bi-x-lg"></i></a>
                    </div>
                </div>
                
                <div class="playlist-music-list" data-list="'.$list.'">
        ';

            $sql_music_from_playlist = "select * from `music` where id in 
                                    (Select `music_id` from `music_playlist` WHERE playlist_id = ".$row['id'].")";

            $rs2 = $dbh->query($sql_music_from_playlist);
            $counter = 1;
            foreach ($rs2->fetchAll() as $item) {
                require_once 'mp3file.class.php';
                $mp3 = new MP3File($item['src']);
                $duration = $mp3->getDuration();
                $d = MP3File::formatTime($duration);

                echo '
                          <div class="element" data-ord="'.$counter.'" data-msrc="'.$item["src"].'">
                            <div class="music-img">
                                <img src="'.$item['isrc'].'">
                                <div class="player-animation">                                    
                                    <span></span>      
                                    <span></span>      
                                    <span></span>      
                                </div>
                            </div>
                            <div class="music-name-and-player">
                                <div class="player">
                                    <button class="play-pause" onclick="playMusic(this)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-play-fill" viewBox="0 0 16 16">
                                            <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="name"><a href="song.php?id='.$item['id'].'">'.$item["name"].' - '.$item["artist"].'</a></div>
                                <div class="time">
                                    <span>00:00</span>/<span>'.substr($d, -5).'</span>
                                </div>
                            </div>
                            <div class="music-operations">
                                <i class="bi bi-arrow-down"></i>
                                <i class="bi bi-arrow-up"></i>
                                <a href="myplaylists.php?effp='.$row['id'].'&effm='.$item['id'].'"><i class="bi bi-x-lg" ></i></a>
                            </div>
                          </div>';
                $counter++;
            }

            echo '</div></div>';
            $list++;
        }
        ?>


        <h1>Chansons</h1>

        <div class="music-list">
            <div class="playlist-music-list">
                <?php
                $sql_music = "select * from `music`";
                $sql_playlists = "Select * from playlist";

                $rs1 = $dbh->query($sql_music);
                $rs2 = $dbh->query($sql_playlists);

                foreach ($rs1->fetchAll() as $row1) {
                    echo '
                <div class="element">
                    <p>' . $row1['name'] . '</p>
                    <form method="get">
                    <input type="hidden" name="mid" value="'.$row1['id'].'">
                    <select name="playlist" >';
                    $rs2 = $dbh->query($sql_playlists);

                    foreach ($rs2->fetchAll() as $row2) {
                        echo '
                            <option value="' . $row2['id'] . '">' . $row2['name'] . '</option>
                            ';
                    }
                    echo '

                    </select>
                    <input type="submit" value="Ajouter">
                </form>
                </div>
            ';
                }?>

            </div>
        </div>
    </div>
</div>
<?php include 'secv/toggle-player.php'?>
<footer>

</footer>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>
<script src="js/player.js"></script>
<script src="js/jquery-3.6.4.min.js""></script>
</body>
</html>
