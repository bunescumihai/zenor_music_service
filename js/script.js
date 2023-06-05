var historyLim = 0;

window.onload = function (){
    time();
    startAnimation();
    showMoreInHistory();
}

var musicIdForPl;

var dSearchBar = document.getElementsByClassName('searchbar')[0];

window.onclick = function (event) {
    if (event.target.contains(dSearchBar) && event.target !== dSearchBar)
        document.getElementsByClassName('searchbar')[0].style.height = '40px';
}

function startAnimation(){
    setTimeout(function (){
        if(dir == 1)
            toLeft();
        else
            toRight();
        startAnimation();
        console.log("Info");
    },7000);
}

var clk = document.getElementById("clock");
var timeOut;

const time = function(){
    let c = new Date();
    let data = c.getDate();
    let luna = c.getMonth()+1;
    let anul = c.getFullYear();
    let ora = c.getHours();
    let min = c.getMinutes();
    let sec = c.getSeconds();

    data = (data < 10)? "0" + data: data;
    luna = (luna < 10)? "0" + luna: luna;
    ora = (ora < 10)? "0" + ora: ora;
    min = (min < 10)? "0" + min: min;
    sec = (sec < 10)? "0" + sec: sec;

    let timp = ora + ":" + min + ":" + sec + "  " + luna + "/" + data + "/" + anul;
    clk.innerText = timp;
    timeOut = setTimeout(function (){
        time();
    }, 500);
}

function stopClock(){
    if(timeOut) {
        clearTimeout(timeOut);
        timeOut = null;
    }
    else
        time();
}

function changePositionToDown(e){
    e = e.parentElement.parentElement;
    e.style.transform = 'translateY(85px)';
    e.nextElementSibling.style.transform = 'translateY(-85px)';
    var element = $(e).parents('.element');
    if(element.not(':nth-child(2)'))
        element.next().after(element);
}

async function changePositionToUp(e){
    e = e.parentElement.parentElement;
    e.style.transform = 'translateY(-85px)';
    e.previousElementSibling.style.transform = 'translateY(85px)';
    setTimeout(function (){
        var element = $(e);
        if(element.not(':nth-child(1)'))
            element.prev().before(element);
        e.style.transform = null;
        e.previousElementSibling.style.transform = null;
    },400);
}

function deleteElement(e){
    e = e.parentElement.parentElement;
    let list = e.parentElement;
    e.style.height = "0";
    e.style.margin = "0px";
    setTimeout(function (){
        e.remove();
        let i = 1;
        for(aux of list.children){
            aux.dataset.ord = i;
            i++;
        }
    },300);

}

function hideMusicBlock(e){
    var arrow =  e.childNodes[1];
    e = e.parentElement.parentElement;
    e.style.height = e.offsetHeight+"px";

    if(e.classList.contains("music-block-element-hidden")){
        e.classList.remove("music-block-element-hidden")
        console.log(e.children.length);
        let h = (e.children[1].offsetHeight+10) * (e.children.length-1) + 65;
        e.style.height = h+"px";
        arrow.classList.remove("rotate180deg");
        setTimeout(function (){
            e.style.height = 'fit-content';
        }, 300);
    }
    else{
        setTimeout(function (){
            e.classList.add("music-block-element-hidden")
            e.style.height = '65px';
            arrow.classList.add("rotate180deg");
        },100)
    }
}

var firstImageIndex = 0;
var pos = 0;
var dir = 1;

function toLeft(){
    let e = document.getElementsByClassName("imag");
    if(firstImageIndex >= e.length-1){
        dir = 0;
        console.log(firstImageIndex)
        return;
    }
    pos -= e[firstImageIndex].offsetWidth + 10;
    firstImageIndex++;
    for(let i = 0; i < e.length; i++)
        e[i].style.transform = 'translateX(' + pos + 'px)';
}

function toRight(){
    let e = document.getElementsByClassName("imag");
    if(firstImageIndex <= 0){
        console.log(firstImageIndex)
        dir = 1;
        return;
    }
    firstImageIndex--;
    pos += e[firstImageIndex].offsetWidth +10;
    for(let i = 0; i < e.length; i++)
        e[i].style.transform = 'translateX(' + pos + 'px)';
}

function closeAddMusicPanel(){
    document.getElementById("add-music-panel").style.display = 'none';
}

function closeCreateAlbumPanel(){
    document.getElementById("create-album-panel").style.display = 'none';
}

function closeCreatePlaylistPanel(){
    document.getElementById("create-playlist-panel").style.display = 'none';
}

function closeAddToPlaylistPanel(){
    document.getElementById("add-to-playlist-panel").style.display = 'none';
}

function showAddMusicPanel(){
    document.getElementById("add-music-panel").style.display = 'flex';
}

function showCreateAlbumPanel(){
    document.getElementById("create-album-panel").style.display = 'flex';
}

function closeUpdateMusicPanel(){
    let e = document.getElementById("update-music-panel");
    e.style.display = 'none';
    let aux = e.getElementsByTagName('input');
    for(let i of aux)
        i.style = 'none';
    aux = e.getElementsByTagName('textarea');
    for(let i of aux)
        i.style = 'none';
    aux = e.getElementsByTagName('select');
    for(let i of aux)
        i.style = 'none';
}

function showUpdateMusicPanel(e){
    let sid = e.parentElement.parentElement.dataset.sid;

    let xmlhttp = new XMLHttpRequest();

    let form = document.updateMusicForm;

    let name = form.name;
    let nameChanged = form.nameChanged;
    let artist = form.artist;
    let artistChanged = form.artistChanged;
    let lyrics = form.lyrics;
    let lyricsChanged = form.lyricsChanged;
    let countries = form.countries;
    let country = form.country;
    let release = form.release;
    let yearr = form.year;
    let genres = form.genres;
    let genre = form.genre;
    let albums = form.albums;
    let album = form.album;
    let id = form.id;

    xmlhttp.onload = function (){
        let response = JSON.parse(this.response);

        name.value = response.song.name;
        nameChanged.value = response.song.name;
        artist.value = response.song.artist;
        artistChanged.value = response.song.artist;
        lyrics.value = response.song.lyrics;
        lyricsChanged.value = response.song.lyrics;
        country.value = response.song.country;
        yearr.value = response.song.release;
        genre.value = response.song.musical_genre;
        album.value = response.song.album;

        id.value = response.song.id;
        countries.innerHTML = '';

        for(let i of response.countries){
            countries.innerHTML += '<option value="' + i.id + '">'+ i.name +'</option>'
        }

        genres.innerHTML = '';
        for(let i of response.musicalGenres){
            genres.innerHTML += '<option value="' + i.id + '">'+ i.name +'</option>'
        }

        albums.innerHTML = '';
        for(let i of response.albums){
            albums.innerHTML += '<option value="' + i.id + '">'+ i.name + '</option>'
        }

        let year = new Date().getFullYear();

        release.innerHTML = '';
        for(let i = 1978; i <=year; i++)
            release.innerHTML += '<option value="' + i + '">'+ i +'</option>'

    }

    xmlhttp.open('GET', 'api/music/get_to_update.php?sid='+sid);
    xmlhttp.send();

    document.getElementById("update-music-panel").style.display = 'flex';
}

function showCreatePlaylistPanel(){
    document.getElementById("create-playlist-panel").style.display = 'flex';
}

function showChangePlaylistName(e){
    e.classList.toggle('is-selected');
    document.getElementById('change-playlist-name').classList.toggle('hidden');
}

function showCreatePlaylist(e){
    e.classList.toggle('is-selected');
    document.getElementById('create-playlist').classList.toggle('hidden');
}

function search(txt){
    let dSearchResults = document.getElementsByClassName('search-results')[0];
    dSearchResults.innerHTML = '';
    let dSearchBar = document.getElementsByClassName('searchbar')[0];
    let xmlhttp = new XMLHttpRequest();

    if(txt.length === 0){
        dSearchResults.style.display = 'none';
        dSearchBar.style.height = '40px';
        return;
    }
    else{
        dSearchResults.style.display = 'block';
        dSearchBar.style.height = 'auto';
    }

    xmlhttp.getResponseHeader('Content-Type', 'application/json');

    xmlhttp.onload = function (){

        let obj = JSON.parse(this.response);

        for(let item of obj.results){
            let aElement = document.createElement('a');
            let text = document.createTextNode(item.name + ' - ' + item.artist);
            aElement.appendChild(text);
            aElement.href = 'song.php?id=' + item.id;
            aElement.classList.add('search-result');
            dSearchResults.appendChild(aElement);
        }

    }

    xmlhttp.open('GET', 'api/music/search.php?search=' + txt);
    xmlhttp.send();
}

function sortby(txt){
    console.log(txt);
}

function musicSort(){
    let sortType = document.sort.sortType.value;
    let limits = document.sort.sortLimits.value;
    console.log(sortType);
    console.log(limits);
    let xmlhttp = new XMLHttpRequest();

    xmlhttp.getResponseHeader('Content-Type', 'application/json');

    xmlhttp.onload = function (){
        console.log(JSON.parse(this.response));
    }

    xmlhttp.open('GET', 'index.php?lim=' + txt);
    xmlhttp.send();
}

function showMoreInHistory(){
    let xmlhttp = new XMLHttpRequest();

    xmlhttp.getResponseHeader('Content-Type', 'application/json');

    xmlhttp.onload = function (){
        let rs = JSON.parse(this.response);
        let list = document.getElementById('history').getElementsByClassName('list-of-music')[0];

        for(e of rs.results){
            $(list).append(createHistoryElement(e));
            historyLim++;
        }

        resetListOrd(1);
    }

    xmlhttp.open('GET', 'api/history/read_10.php?lim=' + historyLim);
    xmlhttp.send();
}

function resetListOrd(listOrd){
    let list = document.querySelector('[data-list="' + listOrd +'"]');
    let i = 1;
    for(aux of list.children){
        aux.dataset.ord = i;
        i++;
    }
}

function createElement(e){
    let s =
        '                          <div class="element" data-ord="1" data-msrc="'+ e.src +'" data-sid="' + e.id + '">\n' +
        '                            <div class="music-img">\n' +
        '                                <img src="'+ e.isrc +'">\n' +
        '                                <div class="player-animation">                                    \n' +
        '                                    <span></span>      \n' +
        '                                    <span></span>      \n' +
        '                                    <span></span>      \n' +
        '                                </div>\n' +
        '                            </div>\n' +
        '                            <div class="music-name-and-player">\n' +
        '                                <div class="player">\n' +
        '                                    <button class="play-pause" onclick="playMusic(this)">\n' +
        '                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-play-fill" viewBox="0 0 16 16">\n' +
        '                                            <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"/>\n' +
        '                                        </svg>\n' +
        '                                    </button>\n' +
        '                                </div>\n' +
        '                                <div class="name"><a href="song.php?id='+e.id+'">' + e.name + ' - ' + e.artist + '</a></div>\n' +
        '                                <div class="time">\n' +
        '                                    <span>00:00</span>/<span>'+e.duration+'</span>\n' +
        '                                </div>\n' +
        '                            </div>\n' +
        '                            <div class="music-operations">\n' +
        '                                <i class="bi bi-arrow-down" onclick="changePositionToDown(this)"></i>\n' +
        '                                <i class="bi bi-music-note-list" title="Ajouter a un playlist"></i>\n' +
        '                                <i class="bi bi-x-lg .delete-a-element-btn" onclick="deleteElement(this); resetCounter(this)"></i>\n' +
        '                            </div>\n' +
        '                            \n' +
        '                            <!--<form class="show-lyrics-form" method="post">\n' +
        '                                <input type="submit" name="showlyrics">\n' +
        '                                    Show Lyrics\n' +
        '                                </input>\n' +
        '                            </forM>-->\n' +
        '                          </div>';
    return s;
}

function createHistoryElement(e){
    let hid='';
    if(e.hid)
        hid = 'data-hid="' + e.hid + '"';

    let s =
        '                          <div class="element" data-ord="1" data-msrc="'+ e.src +'" data-sid="' + e.id + '" '+ hid +'>\n' +
        '                            <div class="music-img">\n' +
        '                                <img src="'+ e.isrc +'">\n' +
        '                                <div class="player-animation">                                    \n' +
        '                                    <span></span>      \n' +
        '                                    <span></span>      \n' +
        '                                    <span></span>      \n' +
        '                                </div>\n' +
        '                            </div>\n' +
        '                            <div class="music-name-and-player">\n' +
        '                                <div class="player">\n' +
        '                                    <button class="play-pause" onclick="playMusic(this)">\n' +
        '                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-play-fill" viewBox="0 0 16 16">\n' +
        '                                            <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"/>\n' +
        '                                        </svg>\n' +
        '                                    </button>\n' +
        '                                </div>\n' +
        '                                <div class="name"><a href="song.php?id='+ e.id +'">' + e.name + ' - ' + e.artist + '</a></div>\n' +
        '                                <div class="time">\n' +
        '                                    <span>00:00</span>/<span>'+e.duration+'</span>\n' +
        '                                </div>\n' +
        '                            </div>\n' +
        '                            <div class="music-operations">\n' +
        '                                <i class="bi bi-arrow-down" onclick="changePositionToDown(this)"></i>\n' +
        '                                <i class="bi bi-music-note-list" title="Ajouter a un playlist" onclick="showAddToPlaylistPanel(this)"></i>\n' +
        '                                <i class="bi bi-x-lg .delete-a-element-btn" title="Effacer d\'histoire" onclick="deleteElement(this); resetCounter(this); deleteFromHistory(this)"></i>\n' +
        '                            </div>\n' +
        '                            \n' +
        '                            <!--<form class="show-lyrics-form" method="post">\n' +
        '                                <input type="submit" name="showlyrics">\n' +
        '                                    Show Lyrics\n' +
        '                                </input>\n' +
        '                            </forM>-->\n' +
        '                          </div>';
    return s;
}

function deleteFromHistory(e){
    let xmlhttp = new XMLHttpRequest();

    let hid = e.parentElement.parentElement.dataset.hid;

    let data = JSON.stringify({hid: hid});

    console.log('hid = ', hid);

    xmlhttp.onload = function (){
        console.log('Super');
    }

    xmlhttp.open('DELETE', 'api/history/del_from_his.php');

    xmlhttp.send(data);
}

function showAddToPlaylistPanel(e){
    document.getElementById("add-to-playlist-panel").style.display = 'flex';

    if(e)
        musicIdForPl = e.parentElement.parentElement.dataset.sid;

    let xmlhttp = new XMLHttpRequest();

    xmlhttp.getResponseHeader('Content-Type', 'application/json');

    xmlhttp.onload = function (){

        let dList = document.getElementById('add-to-playlist-list');
        dList.innerHTML = '';

        let obj = JSON.parse(this.response);

        for(let item of obj.results){
            let dListElement = '<div class="add-to-playlist-element" data-plid="' + item.plid + '">\n' +
                '                    <img src="img/imag.png">\n' +
                '                    <a href="myplaylists.php" title="Aller dans mes playlists">' + item.name + '</a>\n' +
                '                    <button class="add-to-playlist-btn" onclick="addToPlaylist(this)">\n' +
                '                        <span></span>\n' +
                '                        <span></span>\n' +
                '                    </button>\n' +
                '                </div>'

            dList.innerHTML = dList.innerHTML + dListElement;

        }
    }

    xmlhttp.open('GET', 'api/playlist/read_user_playlists.php')
    xmlhttp.send();
}

function addToPlaylist(e){
    e.setAttribute('disabled', 'true');
    let span1 = e.children[0];
    let span2 = e.children[1];
    span1.style.transform = 'rotate(115deg) translate(-4px, -4px)';
    span2.style.transform = 'rotate(50deg) scaleX(0.5) translate(-2px, 7px)';
    span1.style.backgroundColor = 'blue';
    span2.style.backgroundColor = 'blue';
    let plid = e.parentElement.dataset.plid;

    let xmlhttp = new XMLHttpRequest();

    xmlhttp.getResponseHeader('Content-Type', 'application/json');

    xmlhttp.onload = function (){
        console.log('OK');
    }

    xmlhttp.open('GET', 'api/playlist/add_to_playlist.php?id=' + plid + '&musicId=' + musicIdForPl);
    xmlhttp.send();

}

function createAPlaylist(){
    let plName = document.playlistForm.name.value;

    if(plName === '')
        return;

    let playlist = {
        name: plName
    }

    let data = JSON.stringify(playlist);

    let xmlhttp = new XMLHttpRequest();

    xmlhttp.onload = function (){
        console.log(this.response);
        closeCreatePlaylistPanel();
        showAddToPlaylistPanel()
    }

    xmlhttp.open('POST', 'api/playlist/create.php');
    xmlhttp.send(data);
}

function isChanged(e){
    e.style.borderColor = 'green';
    e.style.borderWidth = '3px';
}

function updateMusic(){
    let form = document.updateMusicForm;

    let name = form.nameChanged.value;
    let artist = form.artistChanged.value;
    let lyrics = form.lyricsChanged.value;
    let country_id = form.countries.value;
    let release = form.release.value;
    let genre_id = form.genres.value;
    let album_id = form.albums.value;
    let id = form.id.value;

    let songinfo = {
        id: id,
        name: name,
        artist: artist,
        lyrics: lyrics,
        country_id: country_id,
        release: release,
        genre_id: genre_id,
        album_id: album_id
    }

    let data = JSON.stringify(songinfo);

    let xmlhttp = new XMLHttpRequest();

    xmlhttp.onload = function (){
        console.log(this.response);
        closeUpdateMusicPanel();
    }

    xmlhttp.open('PUT', 'api/music/update.php');
    xmlhttp.send(data);
}