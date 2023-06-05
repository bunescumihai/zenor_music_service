<?php
    class History{
        private $id;
        private $userId;
        private $musicId;
        private $dateAndTime;

        private $conn;

        public function __construct($db){
            $this->conn = $db;
        }

        public function addToHis(){
            $sql = "Insert Into `history` values (NULL, ?, ?, ?)";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(1, $this->userId);
            $stmt->bindParam(2, $this->musicId);
            $stmt->bindParam(3, $this->dateAndTime);

            return $stmt;
        }

        public function read10($userId, $lim){
            $sql = 'SELECT m.*, h.id as hid FROM `music` m INNER JOIN `history` h on m.id = h.music_id WHERE h.user_id = :user_id ORDER BY h.date_and_time DESC LIMIT :lim,10';

            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(':user_id', $userId,PDO::PARAM_INT);
            $stmt->bindValue(':lim', $lim, PDO::PARAM_INT);

            return $stmt;
        }

        public function delFromHis(){
            $sql = 'Delete from `history` where id = :hid';

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':hid', $this->id);

            return $stmt;
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

        public function getMusicId()
        {
            return $this->musicId;
        }

        public function setMusicId($musicId)
        {
            $this->musicId = $musicId;
        }

        public function getDateAndTime()
        {
            return $this->dateAndTime;
        }

        public function setDateAndTime($dateAndTime)
        {
            $this->dateAndTime = $dateAndTime;
        }
    }
?>