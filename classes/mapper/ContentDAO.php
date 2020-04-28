<?php
namespace classes\mapper;

use classes\model\Content;


class ContentDAO{
    private $dbConnect;

    public function __construct(){
        $this->dbConnect = SQLDAOFactory::getInstance();
    }



    public function readContentOfPage($pageNr){
        $contentList = array();
        $pageNummer = "".$pageNr;
        $sql = "SELECT content.*
                FROM content
                WHERE content.page = ?
                ORDER BY content.id";
        $preStmt = $this->dbConnect->prepare($sql);
        $preStmt->bind_param("s", $pageNummer);
        $preStmt->execute();
		$preStmt->store_result();
        $preStmt->bind_result($id, $page, $content, $description, $html_id);
        
        while($preStmt->fetch()){
			$content = new Content($id, $page, $description, $content, $html_id);

			$contentList[] = $content;
        }
        
        $preStmt->free_result();
        $preStmt->close();
        
        return $contentList;
    }

}