<?php

namespace Shaythamc\LinkManagementBundle\Entity;

class Backlink{
	
	public $backlinkId;
	public $name;
	public $url;
	public $alive;
	public $visible;
	public $anchorText;
	public $anchorStatus;
	public $nofollowStatus;
	public $expiration;
	public $siteId;
    public $dateAdded;
	
	public function getBacklinkId(){
		return $this->backlinkId;
	}
	
	public function setBacklinkId($backlinkId){
		$this->backlinkId = $backlinkId;
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function setName($name){
		$this->name = $name;
	}
	
	public function getUrl(){
		return $this->url;
	}
	
	public function setUrl($url){
		$this->url = $url;
	}
	
	public function getAlive(){
		return $this->alive;
	}
	
	public function setAlive($alive){
		$this->alive = $alive;
	}
	
	public function getVisible(){
		return $this->visible;
	}
	
	public function setVisible(){
		$this->visible = $visible;
	}
	
	public function getAnchorText(){
		return $this->anchorText;
	}
	
	public function setAnchorText($anchorText){
		$this->anchorText = $anchorText;
	}
	
	public function getAnchorStatus(){
		return $this->anchorStatus;
	}
	
	public function setAnchorStatus($anchorStatus){
		$this->anchorStatus = $anchorStatus;
	}
	
	public function getNofollowStatus(){
		return $this->nofollow;
	}
	
	public function setNofollowStatus($nofollow){
		$this->nofollow = $nofollow;
	}
    
	public function getSiteId(){
		return $this->siteId;
	}
    
    public function setSiteId($siteId){
        $this->siteId = $siteId;
    }
	
	public function getDateAdded(){
		return $this->dateAdded;
	}
	
	public function setDateAdded($dateAdded){
		$this->dateAdded = $dateAdded;
	}
	
}
