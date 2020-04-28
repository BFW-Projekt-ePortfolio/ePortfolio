<?php
    namespace classes\mapper;

    use classes\model\User;

    class UserDAO {

        private $dbConnect;

        public function __construct() {
            $this->dbConnect = SQLDAOFactory::getInstance();
        }

        public function createUser($firstname, $lastname, $displayname, $email, $password) {
            
            $id = -1;
            
            $sql = "INSERT INTO user (firstname, lastname, displayname, email, passwd, status)
                        VALUES (?,?,?,?,?, 'user')";
            
            if(!$preStmt = $this->dbConnect->prepare($sql)) {
                echo "Fehler bei der SQL-Vorbereitung (" . $this->dbConnect->errno . ")" . $this->dbConnect->error ."<br>";
            } else {
                if(!$preStmt->bind_param("sssss", $firstname, $lastname, $displayname, $email, $password)) {
                    echo "Fehler beim Binding (" . $this->dbConnect->errno . ")" . $this->dbConnect->error ."<br>";
                } else {
                    if(!$preStmt->execute()) {
                        echo "Fehler beim Ausführen (" . $this->dbConnect->errno . ")" . $this->dbConnect->error ."<br>";
                    } else {
                        $id = $preStmt->insert_id;
                    }
                }
            }

            $preStmt->free_result();
            $preStmt->close()
            return $id;
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

        public function changeStatus($id, $newStatus) {
            // ändert den Status (User, Guest, Admin)

            $sql = "UPDATE user
                        SET status = ?
                        WHERE id = ?";
        }
    }
?>