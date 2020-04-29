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
        }

        public function exist($email) {

            $sql = "SELECT id
                        FROM user
                        WHERE email = ?";

            $found = false;

            if(!$preStmt = $this->dbConnect->prepare($sql)){
                echo "Fehler bei SQL-Vorbereitung (" . $this->dbConnect->errno . ")" . $this->dbConnect->error ."<br>";
            }
            else{
                if(!$preStmt->bind_param("s", $email)){
                    echo "Fehler beim Binding (" . $this->dbConnect->errno . ")" . $this->dbConnect->error ."<br>";
                }
                else{
                    if(!$preStmt->execute()){
                        echo "Fehler beim Ausführen (" . $this->dbConnect->errno . ")" . $this->dbConnect->error ."<br>";
                    }
                    else{
                        $preStmt->store_result();
                        if($preStmt->num_rows == 1){
                            $found = true;
                        }
                    }
                }
            }
            return $found;

        }

        public function authenfication($email, $password) {
            
            $user = null;

            if($this->exist($email)) {

                $sql = "SELECT id, displayname, status
                            FROM user
                            WHERE email = ?
                            AND passwd = ?";

                /* an dieser Stelle mit if prüfen, ob guest, user oder admin oder an anderer Stelle? */

                if(!$preStmt = $this->dbConnect->prepare($sql)){
                    echo "Fehler bei SQL-Vorbereitung (" . $this->dbConnect->errno . ")" . $this->dbConnect->error ."<br>";
                }
                else{
                    if(!$preStmt->bind_param("ss", $email, $password)){
                        echo "Fehler beim Binding (" . $this->dbConnect->errno . ")" . $this->dbConnect->error ."<br>";
                    }
                    else{
                        if(!$preStmt->execute()){
                            echo "Fehler beim Ausführen (" . $this->dbConnect->errno . ")" . $this->dbConnect->error ."<br>";
                        }
                        else{
                            if(!$preStmt->bind_result($id, $displayname, $status)){
                                echo "Fehler beim Ergebnis-Binding (" . $this->dbConnect->errno . ")" . $this->dbConnect->error ."<br>";
                            }
                            else{
                                if($preStmt->fetch()){

                                    $pageDAO = new PageDAO();

                                    $pageList = $pageDAO->readPagesOfUserWithContent($id);

                                    $user = new User($id, $displayname, $pageList, $status);
                                }
                                $preStmt->free_result();
                            }
                        }
                    }
                    $preStmt->close();
                }
            }
            return $user;
        }
    }
?>