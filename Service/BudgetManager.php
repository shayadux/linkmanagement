<?php

namespace Shaythamc\LinkManagementBundle\Service;

class BudgetManager{
	
	protected $database;
	
	public function __construct(Database $database){
		$this->database = $database;
	}
    
    /**
     * Create a budget
     * @param float $initial
     */
    public function createBudget($name, $initial){
        $query = 'INSERT INTO Budgets(name, initial, deposited, remaining, spent) VALUES(:name, :initial, :deposited, :remaining, :spent)';
        $data = array(
                    ':name' => $name,
                    ':initial' => $initial,
                    ':deposited' => 0,
                    ':remaining' => $initial,
                    ':spent' => 0,
            );
        
        $this->database->update($query, $data);
    }
    
    /**
     * Get all the budgets
     * @return array
     */
    public function getAllBudgets(){
        $query = 'SELECT * FROM Budgets';
        return $this->database->retrieve($query);
    }
	
    /**
     * Withdraw from the remaining amount left in the budget
     * @param int $budgetId
     * @param float $amount
     * @return 
     */
	public function withdraw($budgetId, $amount){
        $query = 'SELECT remaining, spent FROM Budgets WHERE budgetId = :budgetId';
        $data = array(
                    ':budgetId' => $budgetId,
            );
        
        $budget = $this->database->retrieve($query, $data);
        
        $spent = floatval($budget[0]['spent']);
        $remaining = floatval($budget[0]['remaining']);
        $amount = floatval($amount);

        unset($query);
        
        $query = 'UPDATE Budgets SET remaining = :remaining, spent = :spent WHERE budgetId = :budgetId';
        $data = array(
                    ':remaining' => bcsub($remaining, $amount, 2),
                    ':spent' => bcadd($spent, $amount, 2),
                    ':budgetId' => $budgetId,
                );
        
        try{
            $this->database->update($query, $data);
        }
        catch(Exception $e){
            throw new Exception($e);
        }
    }
    
    /**
     * NOT TESTED
     * @param type $budgetId
     * @param type $amount
     */
    public function deposit($budgetId, $amount){
        $query = 'SELECT deposited, remaining FROM Budgets WHERE budgetId = :budgetId';
        $data = array(':budgetId' => $budgetId);
        
        $budget = $this->database->retrieve($query, $data);
        $deposited = floatval($budget[0]['deposited']);
        $remaining = floatval($budget[0]['remaining']);
        
        unset($query);
        unset($data);
        
        $amount = floatval($amount);

        $query = 'UPDATE Budgets SET deposited = :deposited, remaining = :remaining WHERE budgetId = :budgetId';
        $data = array(
                    ':deposited' => bcadd($deposited, $amount, 2),
                    ':remaining' => bcadd($remaining, $amount, 2),
                    ':budgetId' => $budgetId,
                );
        
        try{
            $this->database->update($query, $data);
        }
        catch(Exception $e){
            throw new Exception($e);
        }
    }
    
    /**
     * Get the remaining amount left in the budget
     * @param type $budgetId
     */
    public function remaining($budgetId){
        $query = 'SELECT remaining FROM Budgets WHERE budgetId = :budgetId';
        $data = array(':budgetId' => $budgetId);
        
        try{
            $this->database->update($query, $data);
        }
        catch(Exception $e){
            throw new Exception($e);
        }
    }
    
    /**
     * Get the amount spent from the budget
     * @param type $budgetId
     */
    public function spent($budgetId){
        $query = 'SELECT spent FROM Budgets WHERE budgetId = :budgetId';
        $data = array(':budgetId' => $budgetId);
        
        try{
            $this->database->update($query, $data);
        }
        catch(Exception $e){
            throw new Exception($e);
        }
    }
    
    
	
}

