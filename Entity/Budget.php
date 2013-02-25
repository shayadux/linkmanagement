<?php

namespace Shaythamc\LinkManagementBundle\Entity;

class Budget{
	
	public $budgetId;
    public $name;
	public $initial;
    public $deposited;
	public $spent;
	public $remaining;
	
	public function getInitial(){
		return $this->initial;
	}
	
	public function setInitial($initial){
		$this->initial = $initial;
	}
    
    public function getName(){
        return $this->name;
    }
    
    public function setName($name){
        $this->name = $name;
    }
    
    public function getDeposited(){
        return $this->added;
    }
    
    public function setDeposited($deposited){
        $this->added = $added;
    }
	
	public function getSpent(){
		return $this->spent;
	}
	
	public function setSpent($spent){
		$this->spent = $spent;
	}
	
	public function getRemaining(){
		return $this->remaining;
	}
	
	public function setRemaining($remaining){
		$this->remaining = $remaining;
	}
	
}
