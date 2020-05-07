<?php
    namespace classes\model;

    class User { //changed 29.04

        private $userId;
        private $firstname;
        private $lastname;
        private $email;
        private $passwd;
        private $validation;
        private $displayname;
        private $status;
        private $pages;

        public function __construct($userId, $firstname = "", $lastname = "" , $email = "", $passwd = "", $validation = 0, $displayname = "", $status, $pages = null) {
            $this->userId = $userId;
            $this->firstname = $firstname;
            $this->lastname = $lastname;
            $this->email = $email;
            $this->passwd = $passwd;
            $this->validation = $validation;
            $this->displayname = $displayname;
            $this->status = $status;
            $this->pages = $pages;

        }

        public function getId() {
            return $this->userId;
        }
        public function setId($id){
            $this->userId = $id;
        }
        public function getFirstname(){
            return $this->firstname;
        }
        public function setFirstname($firstname){
            $this->firstname = $firstname;
        }
        public function getLastname(){
            return $this->lastname;
        }
        public function setLastname($lastname){
            $this->lastname = $lastname;
        }
        public function getEmail(){
            return $this->email;
        }
        public function setEmail($email){
            $this->email = $email;
        }
        public function getPassed(){
            return $this->passwd;
        }
        public function setPasswd($passwd){
            $this->passwd = $passwd;
        }
        public function getValidation(){
            return $this->validation;
        }
        public function setValidation($validation){
            $this->validation = $validation;
        }

        public function getPages() {
            return $this->pages;
        }

        public function setPages($pages) {
            $this->pages = $pages;
        }
        // public function addPage(Page $page){
        //     $this->pages[] = $page;
        // }

        public function getDisplayname() {
            return $this->displayname;
        }
        public function setDisplayname($displayname){
            $this->displayname = $displayname;
        }

        public function getStatus() {
            return $this->status;
        }
        public function setStatus($status){
            $this->status = $status;
        }
    }
?>