<!DOCTYPE html>
<?php
    include_once './php/connect_db.php';
    if(!empty($_GET['id'])){
        $sql = "Select * from music where id = ".intval($_GET['id']);
        $info = $dbh->query($sql);
        $row = '';
        $rows = $info->fetchAll(PDO::FETCH_ASSOC);
        if(count($rows) != 1){
            echo "<h1>Cette chanson n'existe plus</h1>";
            echo "<a href='index.php'> Page d'accueil</a>";
            die();
        }
        else
            $item = $rows[0];
    }

?>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zenor, profil</title>
    <link href="css/bootstrap.css" rel ="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/css.css">
    <link rel="stylesheet" href="css/resp.css">
    <link href="css/song.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>
<body>

<?php include "secv/topbar.php";?>
<?php include 'secv/header.php';?>

<div id="container" class="shadow shadow-info shadow-intensity-lg">
    <div id="content">
        <div id="image">
            <img src="<?php echo $item['isrc']?>">
        </div>
        <div id="song-info">
            <?php
                echo '
                <p><b>Nom de la chanson :</b> '.$item['name'].'</p>
                <p><b>Artiste :</b> '.$item['artist'].'</p>
                <p><b>Album :</b> '.$item['name'].'</p>
                <p><b>Paroles :</b> <br>'.$item['lyrics'].'</p>
                <p><b>Commentaire :</b> '.$item['name'].'</p>
                <p><b>Likes :</b> '.$item['likes'].'</p>
                <p><b>Dislikes :</b> '.$item['dislikes'].'</p>
                ';
            ?>

        </div>
    </div>
    <div class="list-of-music" data-list="1">
        <?php
            $counter = 1;
            include 'secv/element.php';
            $dbh = null;
            ?>
    </div>

</div>

<?php include 'secv/toggle-player.php'?>
<footer>

</footer>
<script src="js/script.js"></script>
<script src="js/player.js"></script>
<script src="js/jquery-3.6.4.min.js""></script>
</body>
</html>
