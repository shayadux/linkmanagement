<?php

namespace Shaythamc\LinkManagementBundle\Entity;

class Link{

	public $linkId;
	public $title;
	public $url;
	public $webmasterId;
	public $keywordNotes;
	public $notes;
	public $expiration;
	public $anchorText;
	public $dateAdded;
	public $price;
	public $active;

	public function getLinkId(){
		return $this->linkId;
	}
	
	public function setLinkId($linkId){
		$this->linkId = $linkId;
	}
	
	public function getTitle(){
		return $this->title;
	}
	
	public function setTitle($title){
		$this->title = $title;
	}
	
	public function getUrl(){
		return $this->url;
	}
	
	public function setUrl($url){
		$this->url = $url;
	}
	
	public function getWebmasterId(){
		return $this->webmasterId;
	}
	
	public function setWebmasterId($webmasterId){
		$this->webmasterId = $webmasterId;
	}
	
	public function getKeywordNotes(){
		return $this->keywordNotes;
	}
	
	public function setKeywordNotes($keywordNotes = null){
		$this->keywordNotes = $keywordNotes;
	}
	
	public function getNotes(){
		return $this->notes;
	}
	
	public function setNotes($notes = null){
		$this->notes = $notes;
	}
	
	public function getExpiration(){
		return $this->expiration;
	}
	
	public function setExpiration($expiration){
		$this->expiration = $expiration;
	}

	public function getAnchorText(){
		return $this->anchorText;
	}
	
	public function setAnchorText($anchorText = null){
		$this->anchorText = $anchorText;
	}
	
	public function getDateAdded(){
		return $this->dateAdded;
	}
	
	public function setDateAdded($dateAdded){
		$this->dateAdded = $dateAdded;
	}
	
	public function getPrice(){
		return $this->price;
	}
	
	public function setPrice($price){
		$this->price = $price;
	}
	
	public function getActive(){
		return $this->active;
	}
	
	public function setActive($active){
		$this->active = (bool) $active;	
	}
 
}
