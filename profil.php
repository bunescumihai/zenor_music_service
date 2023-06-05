<!DOCTYPE html>
<?php
    session_start();
?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zenor, profil</title>
    <link href="css/bootstrap.css" rel ="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/css.css">
    <link rel="stylesheet" href="css/resp.css">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  </head>
  <body>
  <?php if(isset($_SESSION['id'])): ?>
      <div id="add-to-playlist-panel">'
          <button class="exit-button" onclick="closeAddToPlaylistPanel()">
              <span></span>
              <span></span>
          </button>
          <div id="add-to-playlist-block">
              <h3>Ajouter a un playlist</h3>
              <div id="add-to-playlist-list">
              </div>
              <button id="add-to-playlist-creer" class="btn btn-light" onclick="showCreatePlaylistPanel()">
                    Creer un playlist
              </button>
          </div>
      </div>
      <div id="update-music-panel">
          <button class="exit-button" onclick="closeUpdateMusicPanel()">
              <span></span>
              <span></span>
          </button>
          <div class="add-something-form-container">
              <div class="add-something-form-container-logo">
                  <div class="logo">
                      <img src="img/logo.png" alt="">
                      <span><p>ENOR</p></span>
                  </div>
              </div>
              <h2>Actualiser l'information</h2>
              <form name="updateMusicForm">
                  <input name="id" type="hidden">
                  <div class="form-row">
                      <div class="form-group col-md-6">
                          <label for="inputName">Nom</label>
                          <input name="name" type="text" class="form-control" id="inputName" readonly>
                          <i class="bi bi-caret-down-fill"></i>
                          <input name="nameChanged" type="text" class="form-control" onkeyup="isChanged(this)">
                      </div>
                  </div>

                  <div class="form-row">
                      <div class="form-group col-md-6">
                          <label for="inputArtist">Artist</label>
                          <input name="artist" type="text" class="form-control" id="inputArtist" readonly>
                          <i class="bi bi-caret-down-fill"></i>
                          <input name="artistChanged" type="text" class="form-control" onkeyup="isChanged(this)">
                      </div>
                  </div>

                  <div class="form-row">
                      <div class="form-group col-md-6">
                          <label for="inputLyrics">Paroles</label>
                          <textarea id="inputLyrics" class="form-control" name="lyrics" cols="50" rows="3" readonly></textarea>
                          <i class="bi bi-caret-down-fill"></i>
                          <textarea id="inputLyricsChanged" class="form-control" name="lyricsChanged" cols="50" rows="8" onkeyup="isChanged(this)"></textarea>
                      </div>
                  </div>

                  <div class="form-row">
                      <div class="form-group col-md-6">
                          <label for="inputCountry">Pays</label>
                          <input class="form-control" type="text" name="country" readonly>
                          <i class="bi bi-caret-down-fill"></i>
                          <select class="form-select" id="inputCountry" name="countries" onchange="isChanged(this)">

                          </select>
                      </div>
                  </div>

                  <div class="form-row">
                      <div class="form-group col-md-6">
                          <label for="inputYear">Année de sortie</label>
                          <input class="form-control" type="text" name="year" readonly>
                          <i class="bi bi-caret-down-fill"></i>
                          <select class="form-select" id="inputGenre" name="release" onchange="isChanged(this)">
                          </select>
                      </div>
                  </div>

                  <div class="form-row">
                      <div class="form-group col-md-6">
                          <label for="inputGenre">Genre de la chanson</label>
                          <input class="form-control" type="text" name="genre" readonly>
                          <i class="bi bi-caret-down-fill"></i>
                          <select class="form-select" id="inputGenre" name="genres" onchange="isChanged(this)">
                          </select>
                      </div>
                  </div>

                  <div class="form-row">
                      <div class="form-group col-md-6">
                          <label for="inputAlbum">Album</label>
                          <input class="form-control" type="text" name="album" readonly>
                          <i class="bi bi-caret-down-fill"></i>
                          <select class="form-select" id="inputAlbum" name="albums" onchange="isChanged(this)">
                          </select>
                      </div>
                  </div>

                  <br/>
                  <input class="submit-button" type="button" class="auth-button" onclick="updateMusic()" value="Actualiser">
              </form>
          </div>
      </div>
      <div id="create-album-panel">
          <button class="exit-button" onclick="closeCreateAlbumPanel()">
              <span></span>
              <span></span>
          </button>
          <div class="add-something-form-container">
              <form>

              </form>
          </div>
      </div>
      <div id="add-music-panel">
          <button class="exit-button" onclick="closeAddMusicPanel()">
              <span></span>
              <span></span>
          </button>
          <div class="add-something-form-container">
              <form action="php/add_music.php" method="post" enctype="multipart/form-data">
                  <div class="add-something-form-container-logo">
                      <div class="logo">
                          <img src="img/logo.png" alt="">
                          <span><p>ENOR</p></span>
                      </div>
                  </div>
                  <h2>Ajouter un chanson</h2>
                  <div class="form-row">
                      <div class="form-group col-md-6">
                          <label for="inputEmail4">Nom</label>
                          <input name="name" type="text" class="form-control" id="inputEmail4">
                      </div>

                      <div class="form-group col-md-6">
                          <label for="inputPassword4">Artist</label>
                          <input name="artist" type="text" class="form-control" id="inputPassword4">
                      </div>

                      <br>
                      <div class="form-group col-md-6">
                          <label for="inputImage">Image pour le chanson</label>
                          <input type="file" name="image" id="fileImagae" value="Choisir une image" accept=".png, .jpeg, .jpg">
                      </div>

                      <br>
                      <div class="form-group col-md-6">
                          <label for="inputMusic">Fichière</label>
                          <input type="file" name="music" id="inputMusic" value="Choisir un chanson" accept=".mp3">
                      </div>

                  </div>
                  <br/>
                  <input class="submit-button" type="submit" class="auth-button" value="Ajouter">
              </form>
          </div>
      </div>
      <div id="create-playlist-panel">
          <div class="add-something-form-container">
              <button class="exit-button" onclick="closeCreatePlaylistPanel()">
                  <span></span>
                  <span></span>
              </button>
              <div class="add-something-form-container-logo">
                  <div class="logo">
                      <img src="img/logo.png" alt="">
                      <span><p>ENOR</p></span>
                  </div>
              </div>
              <h2>Creer un playlist</h2>
              <form name="playlistForm">
                  <div class="form-row">
                      <div class="form-group col-md-6">
                          <label for="inputEmail4">Nom</label>
                          <input name="name" type="text" class="form-control" id="inputEmail4">
                      </div>
                  </div>
                  <br/>
                  <input class="submit-button" type="button" class="auth-button" onclick="createAPlaylist()" value="Creer">
              </form>
          </div>
      </div>
  <?php endif;?>

    <?php include "secv/topbar.php";?>
    <?php include 'secv/header.php';?>

    <div id="container" class="shadow shadow-info shadow-intensity-lg">
        <div id="content">
            <div id="profil">
                <div id="profil-block">
                    <div class="profil-block-img">
                        <img src="img/profil.png" alt="">
                    </div>
                    <div class="profil-block-info">
                        <?php if(isset($_SESSION['nick_name'])): ?>
                        <p>
                            <?php echo $_SESSION['nick_name']?>
                        </p>
                        <?php endif;?>
                    </div>
                    <div class="profil-block-actions">

                        <?php if(!isset($_SESSION['id'])):?>
                            <p><a href="auth.php">SignIn</a></p>
                        <?php endif;?>
                        <?php if(isset($_SESSION['id'])):?>
                            <form action="php/signout.php">
                                <button type="submit"><p>SignOut</p></button>
                            </form>
                            <button onclick="showCreateAlbumPanel()"><p>Creer un album</p></button>
                            <button onclick="showCreatePlaylistPanel()"><p>Creer un playlist</p></button>
                            <button onclick="showAddMusicPanel()"><p>Ajouter un chanson</p></button>
                        <?php endif;?>

                        <?php if(!isset($_SESSION['id'])):?>
                            <p><a href="reg.php">Register</a></p>
                        <?php endif;?>
                    </div>
                </div>
                <div id="info-block">
                    <div id="history" class="music-block-element">
                        <span class="music-block-name">
                  <h3>Histoire</h3>
                  <button onclick="hideMusicBlock(this)">Hide <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-bar-down" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M1 3.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5zM8 6a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 .708-.708L7.5 12.293V6.5A.5.5 0 0 1 8 6z"/>
                </svg></button>
              </span>
                        <div class="list-of-music" data-list="1">
                        <!--generate music component-->
                            <?php
/*                            include_once('./php/connect_db.php');
                            $sql = "Select * from music";

                            $info = $dbh->query($sql);
                            $counter = 1;
                            $result = $info->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $item) {
                                include 'secv/element.php';
                                $counter++;
                            }
                            $dbh = null;
                            */?>
                        </div>
                        <div class="show-more-block">
                            <button type="button" class="btn btn-light" onclick="showMoreInHistory()">Montre plus</button>
                        </div>
                    </div>
                    <?php if(isset($_SESSION['id'])):?>
                    <div id="my-music" class="music-block-element">
                        <span class="music-block-name">
                  <h3>Mes Chansons</h3>
                  <button onclick="hideMusicBlock(this)">Hide <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-bar-down" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M1 3.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5zM8 6a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 .708-.708L7.5 12.293V6.5A.5.5 0 0 1 8 6z"/>
                </svg></button>
              </span>
                        <!--generate music component-->
                        <div class="list-of-music" data-list="2">
                            <?php
                            include './php/connect_db.php';
                            $sql = "Select * from music where added_by_user_id = ".$_SESSION['id'];
                            $info = $dbh->query($sql);
                            $counter = 1;
                            $result = $info->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $item) {
                                include 'secv/myelement.php';
                                $counter++;
                            }
                            $dbh = null;
                            ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
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
