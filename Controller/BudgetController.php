<?php

namespace Shaythamc\LinkManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Shaythamc\LinkManagementBundle\Entity\Budget;
use Shaythamc\LinkManagementBundle\Form\Type\BudgetType;

//~ use Shaythamc\LinkManagementBundle\Form\Type\LinkType;

class BudgetController extends Controller{

	/**
     * Add a budget 
     * @param Request $request
     * @return type
     */
	public function addBudgetAction(Request $request){
        $budget = new Budget();
        
        $form = $this->createForm(new BudgetType(), $budget);
        
        if($request->isMethod('POST')){
            $form->bind($request);
            $budgetManager = $this->get('lmt_budget_manager');
            $budgetManager->createBudget($budget->getName(), $budget->getInitial());
        }
        
		return $this->render('ShaythamcLinkManagementBundle:Budget:add.html.twig', array(
			'form' => $form->createView(),
		));        
        
	}
	
    public function editBudgetAction(Request $request, $budgetId){
        
    }
    
    public function deleteBudgetAction(Request $request, $budgetId){
        
    }

}
