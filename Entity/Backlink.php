<?php

namespace Shaythamc\LinkManagementBundle\Entity;

class Backlink{
	
	public $backlinkId;
	public $displayText;
	public $url;
	public $urlStatus;
 	public $alive;
	public $visible;
	public $anchorText;
	public $anchorStatus;
	public $nofollowStatus;
	public $expiration;
    public $dateAdded;
    public $lastChecked;
	public $siteId;

	
	public function getBacklinkId(){
		return $this->backlinkId;
	}
	
	public function setBacklinkId($backlinkId){
		$this->backlinkId = $backlinkId;
	}
	
	public function getDisplayText(){
		return $this->displayText;
	}
	
	public function setDisplayText($displayText){
		$this->displayText = $displayText;
	}
	
	public function getUrl(){
		return $this->url;
	}
	
	public function setUrl($url){
		$this->url = $url;
	}
    
    public function getUrlStatus(){
        return $this->urlStatus;
    }
    
    public function setUrlStatus($urlStatus){
        $this->urlStatus = $urlStatus;
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

	public function getDateAdded(){
		return $this->dateAdded;
	}
	
	public function setDateAdded($dateAdded){
		$this->dateAdded = $dateAdded;
	}
    
    public function getLastChecked(){
        return $this->lastChecked;
    }
    
    public function setLastChecked($lastChecked){
        $this->lastChecked = $lastChecked;
    }
    
	public function getSiteId(){
		return $this->siteId;
	}
    
    public function setSiteId($siteId){
        $this->siteId = $siteId;
    }
}
