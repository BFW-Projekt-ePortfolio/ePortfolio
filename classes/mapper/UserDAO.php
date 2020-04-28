<?php
    namespace classes\mapper;

    use classes\model\User;

    class UserDAO {

        private $dbConnect;

        public function __construct() {
            $this->dbConnect = SQLDAOFactory::getInstance();
        }

        public function createUser($firstname, $lastname, $displayname, $email, $password) {
            // erstellt neuen User
        }

        public function createGuest($firstname, $lastname, $displayname, $email, $password) {
            // erstellt neuen Gast
        }

        public function changeDisplayname($oldDisplayname, $newDisplayname) {
            // ändert den Displayname eines Users;
        }

        public function changePassword($oldPassword, $newPassword) {
            // ändert das Passwort des Users
        }

        public function changeEmail($oldEmail, $newEmail) {
            // ändert die Mail
        }

        public function changeStatus($newStatus) {
            // ändert den Status (User, Guest, Admin)
        }
    }
?>