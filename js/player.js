var currentTrack = document.createElement('audio');
    currentTrack.onended = function (){nextTrack()};
var tPath = document.getElementById('play-path');
var tDuration = document.getElementById('toggle-player-controls').getElementsByClassName('time')[0].children[0];
var tCurrentTime = document.getElementById('toggle-player-controls').getElementsByClassName('time')[1].children[0];
var tRange = document.getElementById('toggle-player-controls').getElementsByTagName('input')[0];

var alreadyLoaded = false;
var isPlaying = false;

var currentTime;

var currentListNr = 0;
var currentTrackNr = 0;

var dElement;
var dPlayPausePath;
var dCurrentTime;
var dAnimation;

currentTrack.ontimeupdate = function (){tRange.value = currentTrack.currentTime};
tRange.disabled = true;
tRange.addEventListener('mousedown', pauseM);
tRange.addEventListener('mouseup', playM);

function setCurrentTime(){
    currentTrack.currentTime = tRange.value;
}

function setDuration(){
    setTimeout(function (){
        let duration = Math.round(currentTrack.duration);
        let min = Math.trunc(duration/60);
        let sec = duration%60;
        if(min < 10)
            min = "0" + min;

        if(sec < 10)
            sec = "0" + sec;

        tDuration.innerHTML = min + ':' + sec;
        tRange.value = currentTrack.currentTime;
        tRange.max = duration;

    }, 200);
}

function showCurrentTime(){
    let ctime = currentTrack.currentTime;
    let min = Math.trunc(Math.trunc(ctime)/60);
    let sec = Math.trunc(ctime)%60;
    if(min < 10)
        min = "0" + min;

    if(sec < 10)
        sec = "0" + sec;

    tCurrentTime.innerHTML = min + ':' + sec;
    dCurrentTime.innerHTML = min + ':' + sec;
    currentTime = setTimeout(function (){
        showCurrentTime();
    },50);
}

function pauseM(){
    currentTrack.pause();

    tPath.setAttribute("d", "m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z");
    dPlayPausePath.setAttribute("d", "m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z");

    dAnimation.children[0].style.animationPlayState = 'paused';
    dAnimation.children[1].style.animationPlayState = 'paused';
    dAnimation.children[2].style.animationPlayState = 'paused';

    isPlaying = false;
}

function playM(){

    currentTrack.play();

    tPath.setAttribute("d", "M5.5 3.5A1.5 1.5 0 0 1 7 5v6a1.5 1.5 0 0 1-3 0V5a1.5 1.5 0 0 1 1.5-1.5zm5 0A1.5 1.5 0 0 1 12 5v6a1.5 1.5 0 0 1-3 0V5a1.5 1.5 0 0 1 1.5-1.5z");
    dPlayPausePath.setAttribute("d", "M5.5 3.5A1.5 1.5 0 0 1 7 5v6a1.5 1.5 0 0 1-3 0V5a1.5 1.5 0 0 1 1.5-1.5zm5 0A1.5 1.5 0 0 1 12 5v6a1.5 1.5 0 0 1-3 0V5a1.5 1.5 0 0 1 1.5-1.5z");

    dAnimation.children[0].style.animationPlayState = 'running';
    dAnimation.children[1].style.animationPlayState = 'running';
    dAnimation.children[2].style.animationPlayState = 'running';

    showCurrentTime();

    isPlaying = true;
}

function loadTrack(e, tuchedListNr, tuchedTrack){
    tRange.disabled = false;

    currentListNr = tuchedListNr;
    currentTrackNr = tuchedTrack;

    dElement = e.parentElement.parentElement.parentElement;
    dPlayPausePath = e.children[0].children[0];
    dCurrentTime = dElement.children[1].children[2].children[0];

    dAnimation = dElement.children[0].children[1];

    currentTrack.src = dElement.dataset.msrc;
    currentTrack.load();

    dAnimation.style.display = 'block';

    setDuration();

    playM();
}

function unloadTrack(){

    if(currentTime){
        clearTimeout(currentTime);
        currentTime = null;
    }

    if(dPlayPausePath)
        pauseM();

    if(dAnimation)
        dAnimation.style.display = 'none';

}

function tPlayMusic(){

    if(!alreadyLoaded){
        initializeTrack();
        return;
    }

    if(isPlaying)
        pauseM();
    else
        playM();
}

function playMusic(e){

    alreadyLoaded = true;

    let touchedListNr = e.parentElement.parentElement.parentElement.parentElement.dataset.list;
    let touchedTrack = e.parentElement.parentElement.parentElement.dataset.ord;
    let songId = e.parentElement.parentElement.parentElement.dataset.sid;

    if(touchedListNr === currentListNr && touchedTrack === currentTrackNr){
        if(isPlaying)
            pauseM();
        else
            playM();
    }
    else{
        unloadTrack();
        loadTrack(e, touchedListNr, touchedTrack);
        saveToHistory(songId);
    }

}

function initializeTrack(){
    let e = document.querySelector('[data-list="1"]').getElementsByTagName('button')[0];

    playMusic(e);

    alreadyLoaded = true;
}

function nextTrack(){

    if(!alreadyLoaded){
        initializeTrack();
        return;
    }

    let nextOrd = parseInt(currentTrackNr) + 1;

    let list = document.querySelector('[data-list="' + currentListNr + '"]');
    let element = list.querySelector('[data-ord="' + nextOrd + '"]');

    if(!element){
        nextOrd = 1;
        element = list.querySelector('[data-ord="' + nextOrd + '"]');
    }

    let btn = element.getElementsByTagName('button')[0];
    playMusic(btn);
}

function previousTrack(){
    if(!alreadyLoaded){
        initializeTrack();
        return;
    }

    let prevOrd = parseInt(currentTrackNr) - 1;

    let list = document.querySelector('[data-list="' + currentListNr + '"]');
    let element = list.querySelector('[data-ord="' + prevOrd + '"]');

    if(!element){
        prevOrd = list.childElementCount;
        element = list.querySelector('[data-ord="' + prevOrd + '"]');
    }

    let btn = element.getElementsByTagName('button')[0];
    playMusic(btn);
}

function resetCounter(e){
    let touchedListNr = e.parentElement.parentElement.parentElement.dataset.list;
    let touchedTrack = e.parentElement.parentElement.dataset.ord;
    console.log(touchedListNr)
    console.log(touchedTrack)
    if(touchedTrack === currentTrackNr && touchedListNr === currentListNr){
        alreadyLoaded = false;
        isPlaying = false;
        currentTrackNr = 0;
        currentListNr = 0;
        pauseM();
    }

}

function saveToHistory(songId){
    let xmlhttp = new XMLHttpRequest();

    xmlhttp.onload = function (){
        console.log(JSON.parse(this.response));
    }

    xmlhttp.open('GET', '../api/history/add_to_his.php?sid=' + songId);
    xmlhttp.send();
}