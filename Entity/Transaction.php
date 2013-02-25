<?php

namespace Shaythamc\LinkManagementBundle\Entity;

class Transaction{

	public $transactionId;
	public $amount;
	public $date;
	public $frequency;
	public $linkId;
	public $webmasterId;
	
	public function getTransactionId(){
		return $this->transactionId;
	}
	
	public function setTransactionId($transactionId){
		$this->transactionId = $transactionId;
	}
	
	public function getAmount(){
		return $this->amount;
	}
	
	public function setAmount($amount){
		$this->amount = $amount;
	}
	
	public function getDate(){
		return $this->amount;
	}
	
	public function setDate(){
		$this->date = $date;
	}

}
