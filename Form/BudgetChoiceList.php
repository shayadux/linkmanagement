<?php

namespace Shaythamc\LinkManagementBundle\Form;

use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;

use Shaythamc\LinkManagementBundle\Service\Database;
use Shaythamc\LinkManagementBundle\Service\BudgetManager;

class BudgetChoiceList extends LazyChoiceList {
    
    protected function loadChoiceList(){
        
        $database = new Database();
        $budgetManager = new BudgetManager($database);
        
        $budgets = $budgetManager->getAllBudgets();
        
        $choices = array();
        $labels = array();
        
        foreach($budgets as $key => $value){
			
			array_push($choices, $budgets[$key]['budgetId']);
			array_push($labels, $budgets[$key]['name']);
			
		}
        

        return new ChoiceList($choices, $labels);

    }
}
