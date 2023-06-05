<?php
echo '
    <div id="toggle-player">
        <div id="toggle-player-content">
            <div id="toggle-player-info">
                <div id="toggle-player-image">
                    <div class="music-img">
                        <img src="img/imag.png">
                    </div>
                </div>
                <div id="toggle-player-inf">
                    <p><a href="">Nom chanson</a></p>
                    <p><a href="">Nom artist</a></p>
                    <p><a href="">Date de sortie</a></p>
                </div>
            </div>
            <div id="toggle-player-controls">
                <div id="toggle-player-control-panel">
                    <button class="previous-song" onclick="previousTrack()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="white" class="bi bi-caret-left-fill" viewBox="0 0 16 16">
                            <path d="M4 4a.5.5 0 0 1 1 0v3.248l6.267-3.636c.54-.313 1.232.066 1.232.696v7.384c0 .63-.692 1.01-1.232.697L5 8.753V12a.5.5 0 0 1-1 0V4z"/>
                        </svg>
                    </button>

                    <button class="play-pause" onclick="tPlayMusic()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white" class="bi bi-pause-fill" viewBox="0 0 16 16">
                            <path id="play-path" d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"/>
                        </svg>
                    </button>

                    <button class="next-song" onclick="nextTrack()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="white" class="bi bi-caret-right-fill" viewBox="0 0 16 16">
                            <path d="M12.5 4a.5.5 0 0 0-1 0v3.248L5.233 3.612C4.693 3.3 4 3.678 4 4.308v7.384c0 .63.692 1.01 1.233.697L11.5 8.753V12a.5.5 0 0 0 1 0V4z"/>
                         </svg>
                    </button>
                </div>
                <div class="slider">
                    <input type="range" min="0" value="0" max="143" onchange="setCurrentTime()">
                    <div class="time">
                        <p>00:00</p>
                    </div>
                    <div class="time">
                        <p>00:00</p>
                    </div>
                </div>
            </div>
        </div>
    </div>';
?>