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
			$thisContent = new Content($id, $page, $description, $content, $html_id);

			$contentList[] = $thisContent;
        }
        
        $preStmt->free_result();
        $preStmt->close();
        
        return $contentList;
    }

    public function updateContent(Content $content){
        $nummer = (int)$content->getNummer();
        $pageNummer = (int)$content->getPageNummer();
        $contentDescription = "".$content->getContentDescription();
        $thisContent = "".$content->getContent();
        $html_id = "".$content->getHtml_id();

        $ok = false;
        $sql = "UPDATE content
                SET content.page = ?, content.content = ?, content.description = ?, content.html_id = ?
                WHERE content.id = ?";
        $preStmt = $this->dbConnect->prepare($sql);
		$preStmt->bind_param("sssss", $pageNummer, $thisContent, $contentDescription, $html_id, $nummer);
		$preStmt->execute();
		$ok = $this->dbConnect->affected_rows;
		$preStmt->free_result();
        $preStmt->close();
        
        return $ok;
    }

    public function updateContentGivingAllParameters($contentNr, $pageNr, $description, $theContent, $html_id){
        $nummer = (int)$contentNr;
        $pageNummer = (int)$pageNr;
        $contentDescription = "".$description;
        $thisContent = "".$theContent;
        $thishtml_id = "".$html_id;

        $ok = false;
        $sql = "UPDATE content
                SET content.page = ?, content.content = ?, content.description = ?, content.html_id = ?
                WHERE content.id = ?";
        $preStmt = $this->dbConnect->prepare($sql);
		$preStmt->bind_param("sssss", $pageNummer, $thisContent, $contentDescription, $thishtml_id, $nummer);
		$preStmt->execute();
		$ok = $this->dbConnect->affected_rows;
		$preStmt->free_result();
        $preStmt->close();
        
        return $ok;
    }

}