<?php

namespace Shaythamc\LinkManagementBundle\Form;

use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;

use Shaythamc\LinkManagementBundle\Service\Database;
use Shaythamc\LinkManagementBundle\Service\SiteManager;

class SiteChoiceList extends LazyChoiceList {
    
    protected function loadChoiceList(){
        
        $database = new Database();
        $siteManager = new SiteManager($database);
        
        $sites = $siteManager->getAllSites();
        
        $choices = array();
        $labels = array();
        
        foreach($sites as $key => $value){
			
			array_push($choices, $sites[$key]['siteId']);
			array_push($labels, $sites[$key]['title']);
			
		}
        

        return new ChoiceList($choices, $labels);

    }
}
