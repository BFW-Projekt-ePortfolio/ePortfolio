<?php
    namespace classes\mapper;

    use classes\model\User;
    include_once('./conf/dirs.inc');

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

        public function createGuest($firstname, $lastname, $displayname, $email, $password) {
            
            $id = -1;
            
            $sql = "INSERT INTO user (firstname, lastname, displayname, email, passwd, status, validation)
                        VALUES (?,?,?,?,?, 'guest', 0)";
            
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
                        if($preStmt->num_rows >= 1){
                            $found = true;
                        }
                    }
                }
            }
            return $found;

        }

        public function passwordCheck($email, $passwordLogin) {

            $hashes = array(); // changed on 02.05 hab den Fall einbezogen, dass ein Gast mehrere Freigaben hat.
            $user_ids = array();
            $verifyedUser_ids = array();

            $sql = "SELECT passwd, id
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
                        if(!$preStmt->bind_result($password, $user_id)){
                            echo "Fehler beim Ergebnis-Binding (" . $this->dbConnect->errno . ")" . $this->dbConnect->error ."<br>";
                        } else {
                            while($preStmt->fetch()){
                                $hashes[] = $password;
                                $user_ids[] = $user_id;
                            }
                            $preStmt->free_result();
                        }
                    }
                }
                $preStmt->close();
            }
            // 
            for($i = 0; $i < count($hashes); $i++){
                if(password_verify($passwordLogin, $hashes[$i])) {
                    $verifyedUser_ids[] = $user_ids[$i];
                }
            }

            return $verifyedUser_ids;
        }

        public function authentification($email, $password) {
            // changed on 02.05 hab den Fall einbezogen, dass ein Gast mehrere Freigaben hat.             
            $user = array();
            if($this->exist($email)) {
                $verifyedUser_ids = $this->passwordCheck($email, $password);
                foreach($verifyedUser_ids as $user_id){
                    $id = "".$user_id;
                    $sql = "SELECT user.*
                            FROM user
                            WHERE id = ?";
                  //AND passwd = ?"; -edited out this part- in der Datenbank liegt ja das verschlüsselte PW - dass ist niemal gleich dem unverschlüsseltem $password hier. und die überprüfung hast du ja eh schon in der if abfrage davor gemacht.
                    // hab beu Select auch gleich einfach alles genommen, damit wir den user komplett initialisieren- um ihn dann in die Session zu ballern.
                    if(!$preStmt = $this->dbConnect->prepare($sql)){
                        echo "Fehler bei SQL-Vorbereitung (" . $this->dbConnect->errno . ")" . $this->dbConnect->error ."<br>";
                    } else {
                        if(!$preStmt->bind_param("s", $id)){ // if(!$preStmt->bind_param("ss", $email, $password))
                            echo "Fehler beim Binding (" . $this->dbConnect->errno . ")" . $this->dbConnect->error ."<br>";
                        } else {
                            if(!$preStmt->execute()){
                                echo "Fehler beim Ausführen (" . $this->dbConnect->errno . ")" . $this->dbConnect->error ."<br>";
                            } else {
                                $preStmt->store_result(); // added wegen zwischeinizialisierung von $pagelist
                                if(!$preStmt->bind_result($id, $firstname, $lastname, $email, $passwd, $validation, $displayname, $status)){
                                    echo "Fehler beim Ergebnis-Binding (" . $this->dbConnect->errno . ")" . $this->dbConnect->error ."<br>";
                                } else {
                                    while($preStmt->fetch()){

                                        $pageDAO = new PageDAO();
                                        $pageList = $pageDAO->readPagesOfUserWithContent($id);

                                        $user[] = new User($id, $firstname, $lastname, $email, $passwd, $validation, $displayname, $status, $pageList);
                                    }
                                    $preStmt->free_result();
                                }
                            }
                        }
                        $preStmt->close();
                    }
                }
            }
            return $user;
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

        public function readUserById($userId){
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
            while($preStmt->fetch()){
                $user = new User($id, $firstname, $lastname, $email, $passwd, $validation, $displayname, $status);
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

        public function readAllUsersWithPages($status){
            $userStatus = "".$status;
            $user = array();
            $sql = "SELECT user.* 
                    FROM user
                    WHERE user.status = ?";
            $preStmt = $this->dbConnect->prepare($sql);
            $preStmt->bind_param("s", $userStatus);
            $preStmt->execute();
            $preStmt->store_result();
            $preStmt->bind_result($id, $firstname, $lastname, $email, $passwd, $validation, $displayname, $status);
            
            $pageDAO = new PageDAO;
            while($preStmt->fetch()){
                $pageList = $pageDAO->readPagesOfUser($id);
                $user[] = new User($id, $firstname, $lastname, $email, $passwd, $validation, $displayname, $status, $pageList);
            }
            
            $preStmt->free_result();
            $preStmt->close();
            
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
//
        public function deleteGuest($guestId){
            $guest_id = "".$guestId;
            $pageDAO = new PageDAO;
            $pageDAO->deleteAllPermissionsOfGuest($guest_id);

            $ok = 0;
            $sql = "DELETE FROM user
                    WHERE user.id = ?";
            $preStmt = $this->dbConnect->prepare($sql);
            $preStmt->bind_param("s", $guest_id);
            $preStmt->execute();
            $ok = $this->dbConnect->affected_rows;
            $preStmt->free_result();
            $preStmt->close();
    
            return $ok;

        }

        public function deleteUser($userId){
            $user_id = "".$userId;
            $pageDAO = new PageDAO;
            // -liste von seinen Gästen holen und alle löschen inklusive derer Berechtigungen-
            $myGuestList = $this->readGuestListOfUser($user_id);
            $myPages = $pageDAO->readPagesOfUser($user_id);
            foreach($myGuestList as $guest){
                $guest_id = $guest->getId();

                $pageDAO->deleteAllPermissionsOfGuest($guest_id);
    
                $sql = "DELETE FROM user
                        WHERE user.id = ?";
                $preStmt = $this->dbConnect->prepare($sql);
                $preStmt->bind_param("s", $guest_id);
                $preStmt->execute();
                $preStmt->free_result();
                $preStmt->close();
            }
            // dann die eigenen Permissions löschen.
            $pageDAO->deleteAllPermissionsOfGuest($user_id);
            // dann die Pages des Users alle löschen.
            // hier muss ich leider ein array der am anfang der ganzen löschorgie angelegten seiten übergeben
            // denn zu diesem Zeitpunkt funktionieren die readfunktionen nicht, weil schon rumgelöscht.
            // daher diese blöde funktion eine zeile weiter.
            $pageDAO->deleteAllPagesGivenAllPagesOfUser($myPages);
            // und dann den user löschen
            $ok = 0;
            $sql = "DELETE FROM user
                    WHERE user.id = ?";
            $preStmt = $this->dbConnect->prepare($sql);
            $preStmt->bind_param("s", $user_id);
            $preStmt->execute();
            $ok = $this->dbConnect->affected_rows;
            $preStmt->free_result();
            $preStmt->close();         
            return $ok;
        }

    }
?>