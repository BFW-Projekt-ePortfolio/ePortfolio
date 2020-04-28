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
        $this->html_id = $html_id;
    }

    private function getNummer(){
        return $this->nummer;
    }
    private function setNummer($nummer){
        $this->nummer = $nummer;
    }
    private function getPageNummer(){
        return $this->pageNummer;
    }
    private function setPageNummer($pageNummer){
        $this->pageNummer = $pageNummer;
    }
    private function getContentDescription(){
        return $this->contentDescription;
    }
    private function setContentDescription($contentDescription){
        $this->contentDescription = $contentDescription;
    }
    private function getContent(){
        return $this->content;
    }
    private function setContent($content){
        $this->content = $content;
    }
    private function getHtml_id(){
        return $this->html_id;
    }
    private function setHtml_id($html_id){
        $this->html_id = $html_id;
    }
}