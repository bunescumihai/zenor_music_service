<!DOCTYPE html>
<?php
    include 'php/connect_db.php';
    if (isset($_GET['playlist']) && isset($_GET['name']) && !empty($_GET['name'])) {
        $sql = "UPDATE `playlist` SET `name` = '".$_GET['name']."' WHERE `id` = ".$_GET['playlist'];
        $dbh->exec($sql);
        header("Location: playlist.php");
    } elseif(isset($_GET['name']) && !empty($_GET['name'])){
        $sql = "Insert into `playlist` values (NULL, '".$_GET['name']."',1)";
        $dbh->exec($sql);
        header("Location: playlist.php");
    }elseif(isset($_GET['effp']) && isset($_GET['effm'])){
        $sql = "DELETE FROM `music_playlist` WHERE `playlist_id` = ".$_GET['effp']." and `music_id` = ".$_GET['effm'];
        $dbh->exec($sql);
        header("Location: playlist.php");
    }elseif(isset($_GET['effp'])){
        $sql = "DELETE FROM `music_playlist` WHERE `playlist_id` = ".$_GET['effp'];
        $dbh->exec($sql);
        $sql = "Delete from `playlist` where `id` = ".$_GET['effp'];
        $dbh->exec($sql);
        header("Location: playlist.php");
    }elseif(isset($_GET['mid']) && isset($_GET['playlist'])){
        $sql = "Insert into `music_playlist` values (".$_GET['mid'].",".$_GET['playlist'].")";
        $dbh->exec($sql);
        header("Location: playlist.php");
    }
?>

<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zenor</title>
    <link href="css/bootstrap.css" rel ="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/playlist.css">
</head>
<body>
    <h1>Playlists</h1>

    <?php
    $sql = "Select * from playlist";
    $rs = $dbh->query($sql);
    foreach ($rs->fetchAll() as $row){
        echo '
            <div class="playlist-info">
                <div class="playlist-name">
                    <p>' .$row['name'].'</p>
                    <a href="playlist.php?effp='.$row['id'].'">Effacer</a>
                </div>
                
                <div class="playlist-music-list">
        ';

        $sql_music_from_playlist = "select * from `music` where id in 
                                    (Select `music_id` from `music_playlist` WHERE playlist_id = ".$row['id'].")";

        $rs2 = $dbh->query($sql_music_from_playlist);

        foreach ($rs2->fetchAll() as $row2)
            echo '
                <div class="element">
                    <p>'.$row2['name'].'</p>
                    <a href="playlist.php?effp='.$row['id'].'&effm='.$row2['id'].'">Effacer</a>
                </div>
            ';

        echo '</div></div>';
    }
    ?>


    <div class="action-playlist">
        <h3>Ajouter un playlist</h3>
        <form method="get">
            <input type="text" name="name">
            <input type="submit">
        </form>
    </div>

    <div class="action-playlist">
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
</body>
</html>
