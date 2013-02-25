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
		
		$webmaster = new Webmaster();
		$form = $this->createForm(new WebmasterType(), $webmaster);
					 
		if($request->isMethod('POST')){
			
			$form->bind($request);
			
			$webmasterManager = $this->get('lmt_webmaster_manager');
			$webmasterArray = get_object_vars($webmaster);
			if($webmasterManager->addWebmaster($webmasterArray)){
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

		$webmaster = new Webmaster();
		
		$webmasterManager = $this->get('lmt_webmaster_manager');
		
		$webmasterInfo = $webmasterManager->getWebmaster($webmasterId);
		
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
		
		$form = $this->createForm(new WebmasterType(), $webmaster);
		
		if($request->isMethod('POST')){
			
			$form->bind($request);	
            
			if($request->request->get('_delete')){
				$webmasterManager->deleteWebmaster($webmasterId);
				echo 'Deleted';        
			}
			else{
                
                // Get all properties of the instantiated Webmaster object
                $webmasterArray = get_object_vars($webmaster);
                
                // Tell the WebmasterManager to update the Webmaster's information
                $webmasterManager->editWebmaster($webmasterArray, $webmaster->webmasterId);
			}
		}
		
		return $this->render('ShaythamcLinkManagementBundle:Webmaster:edit.html.twig', array(
            'form' => $form->createView(),
            'webmasterId' => $webmasterId,
        ));
	}
	
	public function viewAllWebmastersAction(){
		
		$webmasterManager = $this->get('lmt_webmaster_manager');
		$allWebmasters = $webmasterManager->getAllWebmasters();
		
		return $this->render('ShaythamcLinkManagementBundle:Webmaster:all.html.twig', array(
            'webmasters' => $allWebmasters,
        ));
	}
	
	public function viewLinksByWebmasterAction($webmasterId){
		$webmasterManager = $this->get('lmt_webmaster_manager');;
		
		$linksByWebmaster = $webmasterManager->getLinksByWebmaster($webmasterId);
		return $this->render('ShaythamcLinkManagementBundle:Webmaster:links.html.twig', array(
            'webmaster' => $linksByWebmaster,
        ));
	}

}
