<?php

namespace Shaythamc\LinkManagementBundle\Service;

class WebmasterManager{

	protected $database;

	public function __construct(Database $database){	
		$this->database = $database;
	}
	
	/**
	 * Add a webmaster
	 * @param array $webmasterArray
	 * @result
	 */
	public function addWebmaster($webmasterArray){
		
		unset($webmasterArray['webmasterId']);
		unset($webmasterArray['dateAdded']);
				
		$data = array();
		foreach($webmasterArray as $key => $webmasterAttribute){
			$data[':' . $key] = $webmasterAttribute;
		}
			
		$query = 'INSERT INTO Webmasters(name, email, phone, skype, icq, forum, forum_user, payment_method, payment_details, notes) VALUES(:name, :email, :phone, :skype, :icq, :forum, :forumUser, :paymentMethod, :paymentDetails, :notes)';
		
		return $this->database->update($query, $data);
				
	}
	
	/**
	 * Get a webmaster's information
	 * @param int $webmasterId
	 * @result array
	 */
	public function getWebmaster($webmasterId){
		
		$query = 'SELECT * FROM Webmasters WHERE webmasterId = :webmasterId';
		$data = array( 
			':webmasterId' => $webmasterId,
		);

		$webmasterArray = $this->database->retrieve($query, $data);
		return $webmasterArray[0]; 
	}
	
	/**
	 * Get all webmasters with their associated data
	 * @result array
	 */
	public function getAllWebmasters(){
		
		$query = 'SELECT * FROM Webmasters';
		return $this->database->retrieve($query);
		
	}
	
	/**
	 * Get all links associated with a webmaster
	 * @param int $webmasterId
	 * @result array
	 */
	public function getLinksByWebmaster($webmasterId){
		
		$linksByWebmaster = array();
				
		$webmaster = $this->getWebmaster($webmasterId);
					
		$query = 'SELECT Links.title, Links.url FROM Webmasters INNER JOIN Links ON Webmasters.webmasterId = Links.webmasterId WHERE Webmasters.webmasterId = :webmasterId';
		$data = array(
			':webmasterId' => $webmasterId,
		);
		
		$links = $this->database->retrieve($query, $data);
		
		var_dump($webmaster['name']);
		var_dump($links[0]);
		
		$linksByWebmaster = array_merge((array) $webmaster['name'], $links[0]);
		
		return $linksByWebmaster;
		
	}
	
	
	/**
	 * Edit a webmaster
	 * @param int $webmasterId
	 * @result 
	 */
	public function editWebmaster($webmasterId){
		
		$query = 'UPDATE Webmasters SET name = :name, email = :email, phone = :phone, social = :social, payment_method = :paymentMethod, payment_details = :paymentDetails, notes = :notes WHERE webmasterId = :webmasterId';
		$data = array(
			':name' => $this->database->name, 
			':email' => $this->database->email,
			':phone' => $this->database->phone,
			':social' => $this->database->social,
			':paymentMethod' => $this->database->paymentMethod,
			':paymentDetails' => $this->database->paymentDetails,
			':notes' => $this->database->notes,
			':webmasterId' => $webmasterId,
		);
		
		$this->database->update($query, $data);
	}
	
	/**
	 * Delete a webmaster
	 * @param int $webmasterId
	 * @result
	 */
	public function deleteWebmaster($webmasterId){
		
		$query = 'DELETE FROM Webmasters where webmasterId = :webmasterId';
		$data = array(
			':webmasterId' => $webmasterId,
		);
		$this->database->update($query, $data);
		
	}
}
