<?php
namespace classes\model;

class Page{
    private $nummer;
    private $owner;
    private $title;
    private $contentList;

    public function __construct($nummer, $owner, $title = "", $contentList = null){
        $this->nummer = $nummer;
        $this->owner = $owner;
        $this->title = $title;
        $this->contentList = $contentList;
    }

    public function getNummer(){
        return $this->nummer;
    }
    public function setNummer($nummer){
        $this->nummer = $nummer;
    }
    public function getOwner(){
        return $this->owner;
    }
    public function setOwner($owner){
        $this->owner = $owner;
    }
    public function getTitle(){
        return $this->title;
    }
    public function setTitle($title){
        $this->title = $title;
    }
    public function getContentList(){
        return $this->contentList;
    }
    public function setContentList($contentList){
        $this->contentList = $contentList;
    }
    public function addContent(Content $Content){
        $this->contentList[] = $Content;
    }

}

