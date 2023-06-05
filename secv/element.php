<?php

    echo '
                          <div class="element" data-ord="'.$counter.'" data-msrc="'.$item["src"].'" data-sid="'.$item['id'].'">
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
                                    <span>00:00</span>/<span>'.$item['duration'].'</span>
                                </div>
                            </div>
                            <div class="music-operations">
                                <i class="bi bi-arrow-down" onclick="changePositionToDown(this)"></i>
                                <i class="bi bi-music-note-list" title="Ajouter a un playlist" onclick="showAddToPlaylistPanel(this)"></i>
                                <i class="bi bi-x-lg" title="Cacher la chanson" onclick="deleteElement(this); resetCounter(this)"></i>
                            </div>
                            
                            <!--<form class="show-lyrics-form" method="post">
                                <input type="submit" name="showlyrics">
                                    Show Lyrics
                                </input>
                            </forM>-->
                          </div>';
?>