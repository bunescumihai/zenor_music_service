<?php
    class Song{
        private $id;
        private $name;
        private $addedByUserId;
        private $artist;
        private $src;
        private $isrc;
        private $duration;
        private $lyrics;
        private $countryId;
        private $musicalGenreId;
        private $albumId;
        private $hearings = 0;
        private $likes = 0;
        private $dislikes = 0;

        private $tableName = 'music';
        private $conn;

       public function __construct($db){
           $this->conn = $db;
       }

       public function read(){
           $sql = 'Select * from ' . $this->tableName . ' LIMIT 0, 40';

           $stmt = $this->conn->prepare($sql);

           $stmt->execute();

           return $stmt;
       }

       public function readBySortTypeAndLimits($stype, $limInf, $count){
           if($stype == 'new')
               $sql = 'Select * from ' . $this->tableName . ' Order by `id` DESC Limit  ' . $limInf . ',' . $count;
           elseif($stype == 'old')
               $sql = 'Select * from ' . $this->tableName . ' Order by `id` ASC Limit ' . $limInf . ',' . $count;
           elseif($stype == 'desc')
               $sql = 'Select * from ' . $this->tableName . ' Order by `name` DESC Limit ' . $limInf . ',' . $count;
           elseif($stype == 'asc')
               $sql = 'Select * from ' . $this->tableName . ' Order by `name` ASC Limit ' . $limInf . ',' . $count;

           $stmt = $this->conn->prepare($sql);
           $stmt->execute();

           return $stmt;
       }

       public function create(){

           $sql = "Insert into " . $this->tableName .
               " values(NULL, :added_by_user_id, :name,  :artist, :src, :isrc, :duration,
               :lyrics, :country_id, :musical_genre_id, :album_id, 
               :hearings, :likes, :dislikes)";

           $stmt = $this->conn->prepare($sql);

           $this->name = htmlspecialchars(strip_tags($this->name));
           $this->artist = htmlspecialchars(strip_tags($this->artist));
           $this->addedByUserId = htmlspecialchars(strip_tags($this->addedByUserId));
           $this->src = htmlspecialchars(strip_tags($this->src));
           $this->isrc = htmlspecialchars(strip_tags($this->isrc));
           $this->duration = htmlspecialchars(strip_tags($this->duration));
           $this->lyrics = htmlspecialchars(strip_tags($this->lyrics));
           $this->countryId = htmlspecialchars(strip_tags($this->countryId));
           $this->musicalGenreId = htmlspecialchars(strip_tags($this->musicalGenreId));
           $this->albumId = htmlspecialchars(strip_tags($this->albumId));
           $this->hearings = htmlspecialchars(strip_tags($this->hearings));
           $this->likes = htmlspecialchars(strip_tags($this->likes));
           $this->dislikes = htmlspecialchars(strip_tags($this->dislikes));

           $stmt->bindParam(":name", $this->name);
           $stmt->bindParam(":artist", $this->artist);
           $stmt->bindParam(":added_by_user_id", $this->addedByUserId);
           $stmt->bindParam(":src", $this->src);
           $stmt->bindParam(":isrc", $this->isrc);
           $stmt->bindParam(":duration", $this->duration);
           $stmt->bindParam(":lyrics", $this->lyrics);
           $stmt->bindParam(":country_id", $this->countryId);
           $stmt->bindParam(":musical_genre_id", $this->musicalGenreId);
           $stmt->bindParam(":album_id", $this->albumId);
           $stmt->bindParam(":hearings", $this->hearings);
           $stmt->bindParam(":likes", $this->likes);
           $stmt->bindParam(":dislikes", $this->dislikes);

           if($stmt->execute()){
               return true;
           }

           return false;

       }

       public function readOne(){
           $sql = 'Select * from ' .$this->tableName. ' where id = ? LIMIT 0,1';

           $stmt = $this->conn->prepare($sql);

           $stmt->bindParam(1, $this->id);

           $stmt->execute();

           $row = $stmt->fetch(PDO::FETCH_ASSOC);
           if(empty($row))
               return;

           $sqlGetAlbum = "Select * from album where id = ? LIMIT 0,1";

           $stmt = $this->conn->prepare($sqlGetAlbum);
           $stmt->bindParam(1, $row['album_id']);
           $stmt->execute();

           $rowAlbum = $stmt->fetch(PDO::FETCH_ASSOC);
           $row['album_id'] = $rowAlbum['name'];


           $this->setAddedByUserId($row['added_by_user_id']);
           $this->setName($row['name']);
           $this->setArtist($row['artist']);
           $this->setSrc($row['src']);
           $this->setLyrics($row['lyrics']);
           $this->setAlbumId($row['album_id']);
           $this->setIsrc($row['isrc']);
           $this->setDuration($row['duration']);
           $this->setCountryId($row['country_id']);
           $this->setMusicalGenreId($row['musical_genre_id']);
           $this->setLikes($row['likes']);
           $this->setDisLikes($row['dislikes']);
           $this->setHearings($row['hearings']);

       }

       public function getArr($row){
           $item = array();

           if(isset($row['id']))
               $item["id"] = $row['id'];

           if(isset($row['name']))
               $item["name"] = $row['name'];

           if(isset($row['artist']))
               $item["artist"] = $row['artist'];

           if(isset($row['added_by_user_id']))
               $item["added_by_user_id"] = $row['added_by_user_id'];

           if(isset($row['src']))
               $item["src"] =  $row['src'];

           if(isset($row['lyrics']))
               $item["lyrics"] = $row['lyrics'];

           if(isset($row['isrc']))
               $item["isrc"] =  $row['isrc'];

           if(isset($row['duration']))
               $item["duration"] =  $row['duration'];

           if(isset($row['album_id']))
               $item["album_id"] = $row['album_id'];

           if(isset($row['country_id']))
               $item["country_id"] = $row['country_id'];

           if(isset($row['musical_genre_id']))
               $item["musical_genre_id"] = $row['musical_genre_id'];

           if(isset($row['hearings']))
               $item["hearings"] = $row['hearings'];

           if(isset($row['likes']))
               $item["likes"] = $row['likes'];

           if(isset($row['dislikes']))
               $item["dislikes"] = $row['dislikes'];

           return $item;
       }

       //GETTERS and SETTERS

        public function getId()
        {
            return $this->id;
        }

        public function setId($id)
        {
            $this->id = $id;
        }

        public function getName()
        {
            return $this->name;
        }

        public function setName($name)
        {
            $this->name = $name;
        }

        public function getAddedByUserId()
        {
            return $this->addedByUserId;
        }

        public function setAddedByUserId($addedByUserId)
        {
            $this->addedByUserId = $addedByUserId;
        }

        public function getArtist()
        {
            return $this->artist;
        }

        public function setArtist($artist)
        {
            $this->artist = $artist;
        }

        public function getSrc()
        {
            return $this->src;
        }

        public function setSrc($src)
        {
            $this->src = $src;
        }

        public function getIsrc()
        {
            return $this->isrc;
        }

        public function setIsrc($isrc)
        {
            $this->isrc = $isrc;
        }

        public function getLyrics()
        {
            return $this->lyrics;
        }

        public function setLyrics($lyrics)
        {
            $this->lyrics = $lyrics;
        }

        public function getCountryId()
        {
            return $this->countryId;
        }

        public function setCountryId($countryId)
        {
            $this->countryId = $countryId;
        }

        public function getMusicalGenreId()
        {
            return $this->musicalGenreId;
        }

        public function setMusicalGenreId($musicalGenreId)
        {
            $this->musicalGenreId = $musicalGenreId;
        }

        public function getAlbumId()
        {
            return $this->albumId;
        }

        public function setAlbumId($albumId)
        {
            $this->albumId = $albumId;
        }

        public function getDuration()
        {
            return $this->duration;
        }

        public function setDuration($duration)
        {
            $this->duration = $duaration;
        }

        public function getHearings()
        {
            return $this->hearings;
        }

        public function setHearings($hearings)
        {
            $this->hearings = $hearings;
        }

        public function getLikes()
        {
            return $this->likes;
        }

        public function setLikes($likes)
        {
            $this->likes = $likes;
        }

        public function getDislikes()
        {
            return $this->dislikes;
        }

        public function setDislikes($dislikes)
        {
            $this->dislikes = $dislikes;
        }


    }
?>