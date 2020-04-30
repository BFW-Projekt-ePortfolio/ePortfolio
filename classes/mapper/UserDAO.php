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
            
            $sql = "INSERT INTO user (firstname, lastname, displayname, email, passwd, status, validation)
                        VALUES (?,?,?,?,?, 'user', 0)";
            
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
            $preStmt->close();
            return $id;
        }

        public function createAdmin($firstname, $lastname, $displayname, $email, $password) {
            
            $id = -1;
            
            $sql = "INSERT INTO user (firstname, lastname, displayname, email, passwd, status, validation)
                        VALUES (?,?,?,?,?, 'admin', 0)";
            
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
            $preStmt->close();
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

        public function passwordCheck($email, $passwordLogin) {

            $passed = false;

            $sql = "SELECT passwd
                        FROM user
                        WHERE email = ?";
            
            if(!$preStmt = $this->dbConnect->prepare($sql)){
                echo "Fehler bei SQL-Vorbereitung (" . $this->dbConnect->errno . ")" . $this->dbConnect->error ."<br>";
            } else {
                if(!$preStmt->bind_param("s", $email)){
                    echo "Fehler beim Binding (" . $this->dbConnect->errno . ")" . $this->dbConnect->error ."<br>";
                } else {
                    if(!$preStmt->execute()){
                        echo "Fehler beim Ausführen (" . $this->dbConnect->errno . ")" . $this->dbConnect->error ."<br>";
                    } else {
                        if(!$preStmt->bind_result($password)){
                            echo "Fehler beim Ergebnis-Binding (" . $this->dbConnect->errno . ")" . $this->dbConnect->error ."<br>";
                        } else {
                            if($preStmt->fetch()) {
                                $hash = $password;
                            }
                            $preStmt->free_result();
                        }
                    }
                }
                $preStmt->close();
            }

            if(password_verify($passwordLogin, $hash)) {
                $passed = true;
            }
            return $passed;
        }

        public function authentification($email, $password) {
            
            $user = null;

            if($this->exist($email)) {
                if($this->passwordCheck($email, $password)) {
                    $sql = "SELECT user.*
                            FROM user
                            WHERE email = ?";
                          //AND passwd = ?"; -edited out this part- in der Datenbank liegt ja das verschlüsselte PW - dass ist niemal gleich dem unverschlüsseltem $password hier. und die überprüfung hast du ja eh schon in der if abfrage davor gemacht.
                            // hab beu Select auch gleich einfach alles genommen, damit wir den user komplett initialisieren- um ihn dann in die Session zu ballern.
                    if(!$preStmt = $this->dbConnect->prepare($sql)){
                        echo "Fehler bei SQL-Vorbereitung (" . $this->dbConnect->errno . ")" . $this->dbConnect->error ."<br>";
                    } else {
                        if(!$preStmt->bind_param("s", $email)){ // if(!$preStmt->bind_param("ss", $email, $password))
                            echo "Fehler beim Binding (" . $this->dbConnect->errno . ")" . $this->dbConnect->error ."<br>";
                        } else {
                            if(!$preStmt->execute()){
                                echo "Fehler beim Ausführen (" . $this->dbConnect->errno . ")" . $this->dbConnect->error ."<br>";
                            } else {
                                $preStmt->store_result(); // added wegen zwischeinizialisierung von $pagelist
                                if(!$preStmt->bind_result($id, $firstname, $lastname, $email, $passwd, $validation, $displayname, $status)){
                                    echo "Fehler beim Ergebnis-Binding (" . $this->dbConnect->errno . ")" . $this->dbConnect->error ."<br>";
                                } else {
                                    if($preStmt->fetch()){

                                        $pageDAO = new PageDAO();
                                        $pageList = $pageDAO->readPagesOfUserWithContent($id);

                                        $user = new User($id, $firstname, $lastname, $email, $passwd, $validation, $displayname, $status, $pageList);
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





        // added 29.04 -latenight


        public function readUserByEmail($email){
            $userEmail = "".$email;
            $sql = "SELECT user.* 
                    FROM user
                    WHERE user.email = ?";
            $preStmt = $this->dbConnect->prepare($sql);
            $preStmt->bind_param("s", $userEmail);
            $preStmt->execute();
            $preStmt->store_result();
            $preStmt->bind_result($id, $firstname, $lastname, $email, $passwd, $validation, $displayname, $status);
            
            $error = 0;
            while($preStmt->fetch()){
                $user = new User($id, $firstname, $lastname, $email, $passwd, $validation, $displayname, $status, null);
                $error++;
            }
            
            $preStmt->free_result();
            $preStmt->close();
            
            if($error != 1){
                return false;
            }
            return $user;
        }

        public function readUserWithPages($userId){
            $uid = "".$userId;
            $sql = "SELECT user.* 
                    FROM user
                    WHERE user.id = ?";
            $preStmt = $this->dbConnect->prepare($sql);
            $preStmt->bind_param("s", $uid);
            $preStmt->execute();
            $preStmt->store_result();
            $preStmt->bind_result($id, $firstname, $lastname, $email, $passwd, $validation, $displayname, $status);
            
            $error = 0;
            $pageDAO = new PageDAO;
            while($preStmt->fetch()){
                $pageList = $pageDAO->readPagesOfUser($id);
                $user = new User($id, $firstname, $lastname, $email, $passwd, $validation, $displayname, $status, $pageList);
                $error++;
            }
            
            $preStmt->free_result();
            $preStmt->close();
            
            if($error != 1){
                return false;
            }
            return $user;
        }

        public function readUserWithPagesAndTheirContent($userId){
            $uid = "".$userId;
            $sql = "SELECT user.* 
                    FROM user
                    WHERE user.id = ?";
            $preStmt = $this->dbConnect->prepare($sql);
            $preStmt->bind_param("s", $uid);
            $preStmt->execute();
            $preStmt->store_result();
            $preStmt->bind_result($id, $firstname, $lastname, $email, $passwd, $validation, $displayname, $status);
            
            $error = 0;
            $pageDAO = new PageDAO;
            while($preStmt->fetch()){
                $pageList = $pageDAO->readPagesOfUserWithContent($id);
                $user = new User($id, $firstname, $lastname, $email, $passwd, $validation, $displayname, $status, $pageList);
                $error++;
            }
            
            $preStmt->free_result();
            $preStmt->close();
            
            if($error != 1){
                return false;
            }
            return $user;
        }


        public function readGuestListOfUser($userId){
            $userList = array();
            $ownerId = "".$userId;
            $sql = 'SELECT user.*
                    FROM user, permission, page
                    WHERE user.status = "guest"
                    AND user.id = permission.user_id
                    AND permission.page = page.id
                    AND page.owner = ?';
            $preStmt = $this->dbConnect->prepare($sql);
            $preStmt->bind_param("s", $ownerId);
            $preStmt->execute();
            $preStmt->store_result();
            $preStmt->bind_result($id, $firstname, $lastname, $email, $passwd, $validation, $displayname, $status);
            
            while($preStmt->fetch()){
                $thisGuest = new User($id, $firstname, $lastname, $email, $passwd, $validation, $displayname, $status, null);
    
                $userList[] = $thisGuest;
            }
            
            $preStmt->free_result();
            $preStmt->close();
            
            return $userList;
        }

        public function readGuestListOfUserWithTheirPages($userId){ // does not load the actual content of the pages into the pages-array
            $userList = array();
            $ownerId = "".$userId;
            $sql = 'SELECT user.*
                    FROM user, permission, page
                    WHERE user.status = "guest"
                    AND user.id = permission.user_id
                    AND permission.page = page.id
                    AND page.owner = ?';
            $preStmt = $this->dbConnect->prepare($sql);
            $preStmt->bind_param("s", $ownerId);
            $preStmt->execute();
            $preStmt->store_result();
            $preStmt->bind_result($id, $firstname, $lastname, $email, $passwd, $validation, $displayname, $status);
            
            $pageDAO = new PageDAO;
            while($preStmt->fetch()){
                $pageList = array();
                $pageList = $pageDAO->readPagesOfUser($id);
                $thisGuest = new User($id, $firstname, $lastname, $email, $passwd, $validation, $displayname, $status, $pageList);
    
                $userList[] = $thisGuest;
            }
            
            $preStmt->free_result();
            $preStmt->close();
            
            return $userList;
        }

    }
?>