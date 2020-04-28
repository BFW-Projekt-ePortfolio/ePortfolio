<?php
namespace classes\mapper;

use classes\model\Page;


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

}