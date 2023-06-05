<?php
    echo '
    <header class="shadow p-3 bg-white rounded">
              <div class="logo">
                <img src="img/logo.png" alt="">
                <span><p>ENOR</p></span>
              </div>
              
              <div class="col-4 search-bar">
                <div class="d-flex justify-content-center h-100 w-100">
                    <div class="searchbar">
                      <input class="search_input" type="text" name="" placeholder="Search..." onkeyup="search(this.value)" >
                      <a href="#" class="search_icon"><i class="bi bi-search"></i></a>
                      <div class="search-results">
                      </div>
                    </div>
                </div>
              </div>

              <nav>
                <ul>
                  <li><a href="index.php">Accueil</a></li>
                  <li><a href="profil.php">Profil</a></li>
                  <li><a href="">Artistes</a></li>
                  <li><a href="">Albums</a></li>
                  <li><a href="">Pays</a></li>
                </ul>
              </nav>

            </header>
    ';
?>