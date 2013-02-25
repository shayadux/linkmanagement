<?php

namespace Shaythamc\LinkManagementBundle\Service;

use PDO;

class Database{
	
	private $_host = 'localhost';
	private $_username = 'root';
	private $_password = 'root';
	private $_database = 'site_management';
	private $_conn; 
	
	/**
	 * Connect to the database when class is instantiated
	 */
	public function __construct(){
		try{
			$this->_conn = new PDO('mysql:host=' . $this->_host . ';dbname=' . $this->_database, $this->_username, $this->_password);
			$this->_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e){
			return 'ERROR: ' . $e->getMessage();
		}
	
	}
	
	/**
	 * Update the database
	 * @param string $query
	 * @param array $data
	 * @result
	 */
	public function update($query, $data){
		try{
			$statement = $this->_conn->prepare($query);
			return $statement->execute($data);
		}
		catch(PDOException $e){
			return 'ERROR: ' . $e->getMessage();
		}
	}
	
	/**
	 * Retrieve data from the database
	 * @param string $query
	 * @param array $data
	 * @result array
	 */
	public function retrieve($query, $data = null){
		try{
			$statement = $this->_conn->prepare($query);
			$statement->execute($data);
			$results = $statement->fetchAll(PDO::FETCH_ASSOC);
						
			if(count($results) !== 0){
				return $results;
			}
			else{
				throw new Exception('No results');
			}
			
		}
		catch(PDOException $e){
			return 'ERROR: ' . $e->getMessage();
		}
	}
}

