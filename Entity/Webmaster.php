<?php

namespace Shaythamc\LinkManagementBundle\Entity;

class Webmaster{
	
	public $webmasterId;
	public $name;
	public $email;
	public $phone;
	public $skype;
	public $icq;
	public $forum;
	public $forumUser;
	public $paymentMethod;
	public $paymentDetails;
	public $notes;
	public $dateAdded;
	
	public function getWebmasterId(){
		return $this->webmasterId;
	}
	
	public function setWebmasterId($webmasterId){
		$this->webmasterId = $webmasterId;
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function setName($name = null){
		$this->name = $name;
	}
	
	public function getEmail(){
		return $this->email;
	}
	
	public function setEmail($email){
		
		if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
			throw new Exception('Not a valid email');
		}
		else{
			$this->email = $email;
		}
	}
	
	public function getPhone(){
		return $this->phone;
	}
	
	public function setPhone($phone){
		$this->phone = $phone;
	}
	
	public function getSkype(){
		return $this->skype;
	}
	
	public function setSkype($skype){
		$this->skype = $skype;
	}
	
	public function getIcq(){
		return $this->icq;
	}
	
	public function setIcq($icq){
		$this->icq = $icq;
	}
	
	public function getForum(){
		return $this->forum;
	}
	
	public function setForum($forum){
		$this->forum = $forum;
	}
	
	public function getForumUser(){
		return $this->forumUser;
	}
	
	public function setForumUser($forumUser){
		$this->forumUser = $forumUser;
	}
	
	public function getPaymentMethod(){
		return $this->paymentMethod;
	}
	
	public function setPaymentMethod($paymentMethod = null){
		$this->paymentMethod = $paymentMethod;
	}
	
	public function getPaymentDetails(){
		return $this->paymentDetails;
	}
	
	public function setPaymentDetails($paymentDetails){
		$this->paymentDetails = $paymentDetails;
	}
	
	public function getNotes(){
		return $this->notes;
	}
	
	public function setNotes($notes){
		$this->notes = $notes;
	}

	public function getDateAdded(){
		return $this->dateAdded;
	}
	
	public function setDateAdded($dateAdded = null){
		$this->dateAdded = $dateAdded;
	}
	
	
	
}
