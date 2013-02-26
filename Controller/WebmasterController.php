<?php

namespace Shaythamc\LinkManagementBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Shaythamc\LinkManagementBundle\Entity\Webmaster;
use Shaythamc\LinkManagementBundle\Form\Type\WebmasterType;

class WebmasterController extends Controller{
	
	/**
	 * Add a webmaster
	 */
	public function addWebmasterAction(Request $request){
		
        // Insantiate a new Webmaster
		$webmaster = new Webmaster();
        
        // Create the form
		$form = $this->createForm(new WebmasterType(), $webmaster);
		
        // If there's a form submission...
		if($request->isMethod('POST')){
			
            // Attach all entered values to the previously instantiated Webmaster object
			$form->bind($request);
			
            // Access the WebmasterManager service
			$webmasterManager = $this->get('lmt_webmaster_manager');
            
            // Get all properties of the instantiated Webmaster object
			$webmasterArray = get_object_vars($webmaster);
			
            // If the Webmaster is added successfully... 
            if($webmasterManager->addWebmaster($webmasterArray)){
				// Give the user some feedback
                return new Response('Webmaster ' . $webmaster->getName() . ' successfully added');
			}
		}
		
		return $this->render('ShaythamcLinkManagementBundle:Webmaster:add.html.twig', array(
            'form' => $form->createView(),
        ));
	}
	
	/**
	 * Edit a webmaster
	 */
	public function editWebmasterAction(Request $request, $webmasterId){
        
        // Insantiate a new Webmaster
		$webmaster = new Webmaster();
		
        // Access the WebmasterManager service
		$webmasterManager = $this->get('lmt_webmaster_manager');
		
        // Retrieve all information for a given Webmaster
		$webmasterInfo = $webmasterManager->getWebmaster($webmasterId);
		
        // Store all retrieved information in the insantiated Webmaster object
        // This allows us to fill our edit form with the existing data
		$webmaster->setWebmasterId($webmasterInfo['webmasterId']);
		$webmaster->setName($webmasterInfo['name']);
		$webmaster->setEmail($webmasterInfo['email']);
		$webmaster->setPhone($webmasterInfo['phone']);
		$webmaster->setSkype($webmasterInfo['skype']);
		$webmaster->setIcq($webmasterInfo['icq']);
		$webmaster->setForum($webmasterInfo['forum']);
		$webmaster->setForumUser($webmasterInfo['forum_user']);
		$webmaster->setPaymentMethod($webmasterInfo['payment_method']);
		$webmaster->setPaymentDetails($webmasterInfo['payment_details']);
		$webmaster->setNotes($webmasterInfo['notes']);
		
        // Render a form with out Webmaster information preloaded into the fields
		$form = $this->createForm(new WebmasterType(), $webmaster);
		
        // If there's a form submission...
		if($request->isMethod('POST')){
			
            // Attach all modified values to the previously instantiated Webmaster object
			$form->bind($request);	
            
            // If the user hits the Delete button...
			if($request->request->get('_delete')){
                // ...delete the Webmaster
				$webmasterManager->deleteWebmaster($webmasterId);
				
                // Give the user some feedback 
                $msg = 'Webmaster ' . $webmaster->getName() . ' has been deleted <br />';
                $msg .= 'You can click Submit to restore the webmaster in case of accidental deletion.';
                echo $msg;
			}
			else{
                
                // Get all properties of the instantiated Webmaster object
                $webmasterArray = get_object_vars($webmaster);
                
                // Tell the WebmasterManager to update the Webmaster's information
                $webmasterManager->editWebmaster($webmasterArray, $webmaster->webmasterId);
                
                // Give the user some feedback
                echo 'Webmaster ' . $webmaster->getName() . ' has been modified';
			}
		}
		
		return $this->render('ShaythamcLinkManagementBundle:Webmaster:edit.html.twig', array(
            'form' => $form->createView(),
            'webmasterId' => $webmasterId,
        ));
	}
	
    /**
     * View all the webmasters
     * @return type
     */
	public function viewAllWebmastersAction(){
		
        // Access the WebmasterManager service
		$webmasterManager = $this->get('lmt_webmaster_manager');
        
        // Get every webmasters information as an array
		$allWebmasters = $webmasterManager->getAllWebmasters();
		
		return $this->render('ShaythamcLinkManagementBundle:Webmaster:all.html.twig', array(
            'webmasters' => $allWebmasters,
        ));
	}
	
    /**
     * NOT TESTED
     * @param type $webmasterId
     * @return type
     */
	public function viewLinksByWebmasterAction($webmasterId){
		
        // Access the WebmasterManager service
        $webmasterManager = $this->get('lmt_webmaster_manager');
        
        // Get the links associated with a given webmaster
		$linksByWebmaster = $webmasterManager->getLinksByWebmaster($webmasterId);
        
		return $this->render('ShaythamcLinkManagementBundle:Webmaster:links.html.twig', array(
            'webmaster' => $linksByWebmaster,
        ));
	}

}
