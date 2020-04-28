<?php
namespace classes\model;

class Content{
    private $nummer;
    private $pageNummer;
    private $contentDescription;
    private $content;
    private $html_id;

    public function __construct ($nummer, $pageNummer, $contentDescription = "", $content = "", $html_id = ""){
        $this->nummer = $nummer;
        $this->pageNummer = $pageNummer;
        $this->contentDescription = $contentDescription;
        $this->content = $content;
        $this->html_id = $html_id;
    }

    public function getNummer(){
        return $this->nummer;
    }
    public function setNummer($nummer){
        $this->nummer = $nummer;
    }
    public function getPageNummer(){
        return $this->pageNummer;
    }
    public function setPageNummer($pageNummer){
        $this->pageNummer = $pageNummer;
    }
    public function getContentDescription(){
        return $this->contentDescription;
    }
    public function setContentDescription($contentDescription){
        $this->contentDescription = $contentDescription;
    }
    public function getContent(){
        return $this->content;
    }
    public function setContent($content){
        $this->content = $content;
    }
    public function getHtml_id(){
        return $this->html_id;
    }
    public function setHtml_id($html_id){
        $this->html_id = $html_id;
    }
}