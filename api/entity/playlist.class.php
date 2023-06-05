<?php
    class Playlist{
        private $id;
        private $userId;
        private $name;
        private $musicId;

        public $conn;

        public function __construct($db){
            $this->conn = $db;
        }

        public function addAPlaylist(){

        }

        public function addToPlaylist(){
            $sql = 'Insert into `music_playlist` (`music_id`, `playlist_id`) values (:music_id, :playlist_id)';

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':music_id', $this->musicId);
            $stmt->bindParam(':playlist_id', $this->id);

            return $stmt;
        }

        public function createAPlaylist(){
            $sql = "Insert into `playlist` values (NULL, :name, :userId)";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':userId', $this->userId);

            return $stmt;
        }



        // GETTERS and SETTERS

        public function getMusicId()
        {
            return $this->musicId;
        }

        public function setMusicId($musicId)
        {
            $this->musicId = $musicId;
        }

        public function getId()
        {
            return $this->id;
        }

        public function setId($id)
        {
            $this->id = $id;
        }

        public function getUserId()
        {
            return $this->userId;
        }

        public function setUserId($userId)
        {
            $this->userId = $userId;
        }

        public function getName()
        {
            return $this->name;
        }

        public function setName($name)
        {
            $this->name = $name;
        }
    }
?>