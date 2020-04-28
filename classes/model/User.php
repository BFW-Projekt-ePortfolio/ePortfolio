<?php
    namespace classes\model;

    class User {

        private $userId;
        private $displayname;
        private $pages;
        private $status;

        public function __construct($userId, $displayname, $pages, $status) {
            $this->userId = $userId;
            $this->displayname = $displayname;
            $this->pages = $pages;
            $this->status = $status;
        }

        public function getId() {
            return $this->userId;
        }

        public function getPages() {
            return $this->pages;
        }

        public function getDisplayname() {
            return $this->displayname;
        }
    }
?>