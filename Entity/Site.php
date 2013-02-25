<?php

namespace Shaythamc\LinkManagementBundle\Entity;

use Exception;

class Site{

	public $siteId;
	public $title;
	public $url;
	public $keyword;
	public $pageFound;
	public $source;
	public $notes;
	public $dateAdded;
	public $price;
    public $budgetId;
	public $webmasterId;
    public $active;

	public function getSiteId(){
		return $this->siteId;
	}
	
	public function setSiteId($siteId){
		$this->siteId = $siteId;
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
		if(filter_var($url, FILTER_VALIDATE_URL) === false){
			throw new Exception('Not a valid URL');
		}
		else{
			$this->url = $url;
		}
	}
	
	public function getWebmasterId(){
		return $this->webmasterId;
	}
	
	public function setWebmasterId($webmasterId){
		if(!is_int( (int) $webmasterId)){
			throw new Exception('Webmaster ID must be an integer');
		}
		else{
			$this->webmasterId = $webmasterId;
		}
	}
	
	public function getKeyword(){
		return $this->keyword;
	}
	
	public function setKeyword($keyword){
		$this->keyword = $keyword;
	}
	
	public function getPageFound(){
		return $this->pageFound;
	}
	
	public function setPageFound($pageFound){
		$this->pageFound = $pageFound;
	}
	
	public function getSource(){
		return $this->source;
	}
	
	public function setSource($source){
		$this->source = $source;
	}
	
	public function getNotes(){
		return $this->notes;
	}
	
	public function setNotes($notes = null){
		$this->notes = $notes;
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
    
    public function getBudgetId(){  
        return $this->budgetId;
    }
    
    public function setBudgetId($budgetId){
        $this->budgetId = $budgetId;
    }
    
    public function getActive(){
        return $this->active;
    }
    
    public function setActive($active){
        $this->active = $active;
    }
	
 
}
