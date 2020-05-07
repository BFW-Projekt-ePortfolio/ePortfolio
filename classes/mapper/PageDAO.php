<?php
namespace classes\mapper;

use classes\model\Page;
use classes\model\User;


class PageDAO{
    private $dbConnect;

    public function __construct(){
        $this->dbConnect = SQLDAOFactory::getInstance();
    }



    public function readPagesOfUserWithContent($userNr){
        $pageList = array();
        $userNummer = "".$userNr;
        $sql = "SELECT page.* 
                FROM page, permission, user
                WHERE page.id = permission.page
                AND permission.user_id = user.id
                AND user.id = ?
                ORDER BY page.id";
        $preStmt = $this->dbConnect->prepare($sql);
        $preStmt->bind_param("s", $userNummer);
        $preStmt->execute();
		$preStmt->store_result();
        $preStmt->bind_result($id, $owner, $title);
        
        $contentDao = new ContentDAO;
        while($preStmt->fetch()){
            $contentList = $contentDao->readContentOfPage($id);

            $page = new Page($id, $owner, $title, $contentList);
			$pageList[] = $page;
        }
        
        $preStmt->free_result();
        $preStmt->close();

        return $pageList;
    }

    public function readPagesOfUser($userNr){
        $pageList = array();
        $userNummer = "".$userNr;
        $sql = "SELECT page.* 
                FROM page, permission, user
                WHERE page.id = permission.page
                AND permission.user_id = user.id
                AND user.id = ?
                ORDER BY page.id";
        $preStmt = $this->dbConnect->prepare($sql);
        $preStmt->bind_param("s", $userNummer);
        $preStmt->execute();
		$preStmt->store_result();
        $preStmt->bind_result($id, $owner, $title);
        
        while($preStmt->fetch()){
            $page = new Page($id, $owner, $title);
			$pageList[] = $page;
        }
        
        $preStmt->free_result();
        $preStmt->close();

        return $pageList;
    }

    public function createPage($ownerId, $title){

        $owner = "".$ownerId;
        $pageTitle = "".$title;

        $ok = -1;
        $sql = "INSERT INTO page (owner, title)
                VALUES (?,?)";
        $preStmt = $this->dbConnect->prepare($sql);
        $preStmt->bind_param("ss", $owner, $pageTitle);
        $preStmt->execute();
        $ok = $preStmt->insert_id;
        $preStmt->close();
        unset($preStmt);

        return $ok;
    }

    public function createPagePassingPageObject(Page $page){

        $owner = "".$page->getOwner();
        $pageTitle = "".$page->getTitle();

        $ok = -1;
        $sql = "INSERT INTO page (owner, title)
                VALUES (?,?)";
        $preStmt = $this->dbConnect->prepare($sql);
        $preStmt->bind_param("ss", $owner, $pageTitle);
        $preStmt->execute();
        $ok = $preStmt->insert_id;
        $preStmt->close();
        unset($preStmt);

        return $ok;
    }

    public function setPermissionForPage($guestIdToSetPermissionFor, $pageId){

        $id = "".$guestIdToSetPermissionFor;
        $page = "".$pageId;
        $ok = -1;
        $sql = "INSERT INTO permission (user_id, page)
                VALUES (?,?)";
        $preStmt = $this->dbConnect->prepare($sql);
        $preStmt->bind_param("ss", $id, $page);
        $preStmt->execute();
        $ok = $preStmt->insert_id;
        $preStmt->close();
        unset($preStmt);

        return $ok;
    }

    public function setPermissionForPagePassingObjects(User $user,Page $page){

        $id = "".$user->getId();
        $page = "".$page->getNummer();
        $ok = -1;
        $sql = "INSERT INTO permission (user_id, page)
                VALUES (?,?)";
        $preStmt = $this->dbConnect->prepare($sql);
        $preStmt->bind_param("ss", $id, $page);
        $preStmt->execute();
        $ok = $preStmt->insert_id;
        $preStmt->close();
        unset($preStmt);

        return $ok;
    }
//
    public function deletePermissionOfGuestForPage($guestId, $pageId){

        $user_id = "".$guestId;
        $page_id = "".$pageId;
        $ok = 0;
        $sql = "DELETE FROM permission
                WHERE permission.user_id = ?
                AND permission.page = ?";
        $preStmt = $this->dbConnect->prepare($sql);
        $preStmt->bind_param("ss", $user_id, $page_id);
        $preStmt->execute();
        $ok = $this->dbConnect->affected_rows;
        $preStmt->free_result();
        $preStmt->close();

        return $ok;
    }

    public function deleteAllPermissionsOfGuest($guestId){

        $user_id = "".$guestId;
        $ok = 0;
        $sql = "DELETE FROM permission
                WHERE permission.user_id = ?";
        $preStmt = $this->dbConnect->prepare($sql);
        $preStmt->bind_param("s", $user_id);
        $preStmt->execute();
        $ok = $this->dbConnect->affected_rows;
        $preStmt->free_result();
        $preStmt->close();

        return $ok;
    }

    public function deletePage($pageId){
        $page_id = "".$pageId;
        // Content muss mitgelöscht werden
        $contentDao = new ContentDao;
        $contentDao->deleteAllContentOfPage($page_id);
        // Jetzt wird die Seite gelöscht
        $ok = 0;
        $sql = "DELETE FROM page
                WHERE page.id = ?";
        $preStmt = $this->dbConnect->prepare($sql);
        $preStmt->bind_param("s", $page_id);
        $preStmt->execute();
        $ok = $this->dbConnect->affected_rows;
        $preStmt->free_result();
        $preStmt->close();

        
        return $ok;
    }

    public function deleteAllPagesOfUser($userId){
        $user_id = "".$userId;
        // der Content muss erst gelöscht werden.
        $contentDao = new ContentDao;
        $myPages = $this->readPagesOfUser($user_id);
        
        foreach($myPages as $page){
            $page_id = $page->getNummer();
            $contentDao->deleteAllContentOfPage($page_id);
        }
        // jetzt die Seiten
        $ok = 0;
        $sql = "DELETE FROM page
                WHERE page.owner = ?";
        $preStmt = $this->dbConnect->prepare($sql);
        $preStmt->bind_param("s", $user_id);
        $preStmt->execute();
        $ok = $this->dbConnect->affected_rows;
        $preStmt->free_result();
        $preStmt->close();

        return $ok;
    }

    public function deleteAllPagesGivenAllPagesOfUser($pageList){
        // der Content muss erst gelöscht werden.
        $contentDao = new ContentDao;
        
        foreach($pageList as $page){
            $page_id = $page->getNummer();
            $contentDao->deleteAllContentOfPage($page_id);

            // jetzt die Seiten
            $sql = "DELETE FROM page
                    WHERE page.id = ?";
            $preStmt = $this->dbConnect->prepare($sql);
            $preStmt->bind_param("s", $page_id);
            $preStmt->execute();
            $ok = $this->dbConnect->affected_rows;
            $preStmt->free_result();
            $preStmt->close();
        }
    }

    public function updatePageTitle($pageId, $title){
        $page_id = "".$pageId;
        $pageTitle = "".$title;

        $ok = false;
        $sql = "UPDATE page
                SET page.title = ?
                WHERE page.id = ?";
        $preStmt = $this->dbConnect->prepare($sql);
		$preStmt->bind_param("ss", $pageTitle, $page_id);
		$preStmt->execute();
		$ok = $this->dbConnect->affected_rows;
		$preStmt->free_result();
        $preStmt->close();
        
        return $ok;
    }


}