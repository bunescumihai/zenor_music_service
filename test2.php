<?php
    class Song{
        private $name;
        private $artist;

        public function __construct($name, $artist)
        {
            $this->artist = $artist;
            $this->name = $name;
        }

        public function getName()
        {
            return $this->name;
        }

        public function setName($name)
        {
            $this->name = $name;
        }

        public function getArtist()
        {
            return $this->artist;
        }

        public function setArtist($artist)
        {
            $this->artist = $artist;
        }

    }
    class Playlist{

        private $name;
        public function __construct($name)
        {
            $this->name = $name;
        }

        public function getName(){
            return $this->name;
        }
    }

    $song = new Song('I Got You', 'Bebe Rexha');
    $playlist = new Playlist('Penitenciarul-143');

    echo $song->getArtist().'<br>';
    echo $song->getName().'<br>';
    echo $playlist->getName().'<br>';
?>