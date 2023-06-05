<!DOCTYPE html>
<?php
    session_start();

    include_once('./php/connect_db.php');
    include_once 'api/config/database.class.php';
    include_once 'api/entity/song.class.php';

    $database = new Database();
    $db = $database->getConnection();
    $song = new Song($db);


    if(isset($_GET['lim']) && !empty($_GET['lim'])){
        global $db;
        global $song;

        $sql = "Select * from music limit 0,5";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $results_arr = array();
        $results_arr['results'] = array();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $item = $song->getArr($row);
            array_push($results_arr['results'], $item);
        }

        echo json_encode($results_arr);
        exit;
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  </head>
  <body>
  <?php if(isset($_SESSION['id'])): ?>
      <div id="add-to-playlist-panel">
          <div id="add-to-playlist-block">
              <button class="exit-button" onclick="closeAddToPlaylistPanel()">
                  <span></span>
                  <span></span>
              </button>
              <h3>Ajouter a un playlist</h3>
              <div id="add-to-playlist-list">

              </div>
              <button class="btn btn-light" id="add-to-playlist-creer">
                  Creer un playlist
              </button>
          </div>
      </div>
  <?php endif;?>
    <?php include "secv/topbar.php"?>
    <?php include "secv/header.php"?>
    <div id="container" class="shadow shadow-info shadow-intensity-lg">
      <div id="content">
        <h1>Chansons</h1>
          <div id="defilement">
              <button class="move-to-left" onclick="toRight()">
                <span class="circle">
                    <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M24 12l-9-8v6h-15v4h15v6z"/></svg>
                </span>
              </button>
              <button class="move-to-right" onclick="toLeft()">
                <span class="circle">
                    <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M24 12l-9-8v6h-15v4h15v6z"/></svg>
                </span>
              </button>
              <?php
                $sql = "SELECT `id`, `isrc` FROM `music` ORDER BY `id` DESC LIMIT 15";
                $info = $dbh->query($sql);
                $result = $info->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $item) {
                  echo '
                      <a class="imag" href="song.php?id='.$item['id'].'">
                          <img src="'.$item['isrc'].'" alt="">
                      </a>
                  ';
                }
              ?>
          </div>
          <div class="music">
              <div class="music-block">
                <div id="nouvelles" class="music-block-element">
                  <span class="music-block-name">
                      <h3>Nouvelles</h3>
                      <form class="sort" name="sort" action>
                          <label for="sort-type"> Order by: </label>
                          <select name="sortType" class="form-select" id="sort-type" onchange="musicSort()">
                              <option value="new">Les plus récentes</option>
                              <option value="desc">Nom, descendant</option>
                              <option value="asc">Nom, ascendant</option>
                              <option value="old">Plus ancien</option>
                          </select>

                          <label for="sort-limits"> Show: </label>
                          <select name="sortLimits" class="form-select" id="sort-limits" onchange="musicSort()">
                              <option value="5">5 chansons</option>
                              <option value="15">15 chansons</option>
                              <option value="30">30 chansons</option>
                              <option value="50">50 chansons</option>
                          </select>
                      </form>
                      <button onclick="hideMusicBlock(this)">Hide <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-bar-down" viewBox="0 0 16 16">
                      <path fill-rule="evenodd" d="M1 3.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5zM8 6a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 .708-.708L7.5 12.293V6.5A.5.5 0 0 1 8 6z"/>
                    </svg></button>
                  </span>
                    <!--generate music component-->
                    <div class="list-of-music" data-list="1">
                        <?php
                            $sql = "Select * from music";
                            $info = $dbh->query($sql);
                            $result = $info->fetchAll(PDO::FETCH_ASSOC);
                            $counter = 1;
                            foreach ($result as $item){
                                include 'secv/element.php';
                                $counter++;
                            }
                            $dbh = null;
                        ?>
                    </div>
                    <div class="page-block">
                        <nav aria-label="...">
                            <ul class="pagination">
                                <li class="page-item disabled">
                                    <span class="page-link">Previous</span>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item active">
                              <span class="page-link">
                                2
                              </span>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
              </div>
              <div id="playlists-block" >
            <div id="playlists-block-name">
              PlayLists
            </div>
            <a class="playlist-element">
                <div class="playlist-img">
                    <img src="img/1.jpg" alt="image">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-music-note-list" viewBox="0 0 16 16">
                        <path d="M12 13c0 1.105-1.12 2-2.5 2S7 14.105 7 13s1.12-2 2.5-2 2.5.895 2.5 2z"/>
                        <path fill-rule="evenodd" d="M12 3v10h-1V3h1z"/>
                        <path d="M11 2.82a1 1 0 0 1 .804-.98l3-.6A1 1 0 0 1 16 2.22V4l-5 1V2.82z"/>
                        <path fill-rule="evenodd" d="M0 11.5a.5.5 0 0 1 .5-.5H4a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 .5 7H8a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 .5 3H8a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5z"/>
                    </svg>
                </div>
                <div class="playlist-name">
                    <span>Hello Hello Hello</span>
                </div>
            </a>
            <a class="playlist-element">
                <div class="playlist-img">
                    <img src="img/1.jpg" alt="image">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-music-note-list" viewBox="0 0 16 16">
                        <path d="M12 13c0 1.105-1.12 2-2.5 2S7 14.105 7 13s1.12-2 2.5-2 2.5.895 2.5 2z"/>
                        <path fill-rule="evenodd" d="M12 3v10h-1V3h1z"/>
                        <path d="M11 2.82a1 1 0 0 1 .804-.98l3-.6A1 1 0 0 1 16 2.22V4l-5 1V2.82z"/>
                        <path fill-rule="evenodd" d="M0 11.5a.5.5 0 0 1 .5-.5H4a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 .5 7H8a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 .5 3H8a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5z"/>
                    </svg>
                </div>
                <div class="playlist-name">
                    <span>Hello Hello Hello</span>
                </div>
            </a>
            <a class="playlist-element">
                <div class="playlist-img">
                    <img src="img/1.jpg" alt="image">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-music-note-list" viewBox="0 0 16 16">
                        <path d="M12 13c0 1.105-1.12 2-2.5 2S7 14.105 7 13s1.12-2 2.5-2 2.5.895 2.5 2z"/>
                        <path fill-rule="evenodd" d="M12 3v10h-1V3h1z"/>
                        <path d="M11 2.82a1 1 0 0 1 .804-.98l3-.6A1 1 0 0 1 16 2.22V4l-5 1V2.82z"/>
                        <path fill-rule="evenodd" d="M0 11.5a.5.5 0 0 1 .5-.5H4a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 .5 7H8a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 .5 3H8a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5z"/>
                    </svg>
                </div>
                <div class="playlist-name">
                    <span>Hello Hello Hello</span>
                </div>
            </a>
            <a class="playlist-element">
                <div class="playlist-img">
                    <img src="img/1.jpg" alt="image">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-music-note-list" viewBox="0 0 16 16">
                        <path d="M12 13c0 1.105-1.12 2-2.5 2S7 14.105 7 13s1.12-2 2.5-2 2.5.895 2.5 2z"/>
                        <path fill-rule="evenodd" d="M12 3v10h-1V3h1z"/>
                        <path d="M11 2.82a1 1 0 0 1 .804-.98l3-.6A1 1 0 0 1 16 2.22V4l-5 1V2.82z"/>
                        <path fill-rule="evenodd" d="M0 11.5a.5.5 0 0 1 .5-.5H4a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 .5 7H8a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 .5 3H8a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5z"/>
                    </svg>
                </div>
                <div class="playlist-name">
                    <span>Hello Hello Hello</span>
                </div>
            </a>
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
