<?php

namespace Shaythamc\LinkManagementBundle\Form;

use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;

use Shaythamc\LinkManagementBundle\Service\Database;
use Shaythamc\LinkManagementBundle\Service\WebmasterManager;

class WebmasterChoiceList extends LazyChoiceList {
    
    protected function loadChoiceList(){
        
        $database = new Database();
        $webmasterManager = new WebmasterManager($database);
        
        $webmasters = $webmasterManager->getAllWebmasters();
        
        $choices = array();
        $labels = array();
        
        foreach($webmasters as $key => $value){
			
			array_push($choices, $webmasters[$key]['webmasterId']);
			array_push($labels, $webmasters[$key]['name']);
			
		}

        return new ChoiceList($choices, $labels);

    }
}
