<?php

namespace Shaythamc\LinkManagementBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use ArrayObject;

use Shaythamc\LinkManagementBundle\Entity\Link;
use Shaythamc\LinkManagementBundle\Form\Type\LinkType;

use Shaythamc\LinkManagementBundle\Entity\Backlink;
use Shaythamc\LinkManagementBundle\Form\Type\BacklinkType;

use Shaythamc\LinkManagementBundlle\Entity\Transaction;

class LinkController extends Controller{
	
	/**
	 * Add a link
	 */
	public function addLinkAction(Request $request){
		$link = new Link();

		$form = $this->createForm(new LinkType(), $link);
		
		if($request->isMethod('POST')){
			
			$form->bind($request);
			$linkManager = $this->get('lmt_link_manager');
			$linkArray = get_object_vars($link);
			$linkManager->addLink($linkArray);
		}
		
		return $this->render('ShaythamcLinkManagementBundle:Link:add.html.twig', array(
			'form' => $form->createView(),
		));
	}
	
	/**
	 * Edit a link
	 */
	public function editLinkAction(Request $request, $linkId){
		
		$link = new Link();
		
		$linkManager = $this->get('lmt_link_manager');
		
		$linkInfo = $linkManager->getLink($linkId);
		
		$link->setLinkId($linkInfo['linkId']);
		$link->setTitle($linkInfo['title']);
		$link->setUrl($linkInfo['url']);
		$link->setWebmasterId($linkInfo['webmasterId']);
		$link->setKeywordNotes($linkInfo['keyword_notes']);
		$link->setNotes($linkInfo['notes']);
		$link->setExpiration($linkInfo['expiration']);			
		$link->setAnchorText($linkInfo['anchor_text']);
		$link->setPrice($linkInfo['price']);
		$link->setActive($linkInfo['active']);
		
		$form = $this->createForm(new LinkType(), $link);
		
		if($request->isMethod('POST')){
			
			$form->bind($request);
			
			if($request->request->get('_delete')){		
				$linkManager->deleteLink($linkId);
				return $this->redirect($this->generateUrl('shaythamc_link_management_homepage'));
			}
			else{
				$linkArray = get_object_vars($link);
				$linkManager->editLink($linkId, $linkArray);
				return $this->redirect($this->generateUrl('shaythamc_link_management_view_all_links'));
			}
		}
		
		return $this->render('ShaythamcLinkManagementBundle:Link:edit.html.twig', array(
            'form' => $form->createView(),
            'linkId' => $linkId,
        ));
	}
	
	/**
	 * View all links
	 */
	public function viewAllLinksAction(Request $request){
		
		$linkManager = $this->get('lmt_link_manager');
			
		$allLinks = $linkManager->getAllLinks();
		
		$seostats = $this->get('seostats');
		
		$linkData = array();
		
		
		foreach($allLinks as $key => $value){
			
			$url = $allLinks[$key]['url'];
			$allLinks[$key]['pagerank'] = $seostats->Google()->getPageRank($url);
			$allLinks[$key]['globalrank'] = $seostats->Alexa()->getGlobalRank($url);
		}
		
		$data = array();
		
		$form = $this->createFormBuilder()->getForm();

		if($request->isMethod('POST')){
			
			$form->bind($request);
			
			if($request->request->get('_delete')){
				$linkManager->deleteLink($request->request->get('linkId'));
				return $this->redirect($this->generateUrl('shaythamc_link_management_view_all_links'));
			}
			elseif($request->request->get('_edit')){
				$linkId = $request->request->get('linkId');
				return $this->redirect($this->generateUrl('shaythamc_link_management_edit_link', array('linkId' => $linkId)));
			}
		}
		
		
		
		return $this->render('ShaythamcLinkManagementBundle:Link:all.html.twig', array(
            'form' => $form->createView(),
            'links' => $allLinks,
        ));
	}
	
	public function viewStatsAction(){
		
		$seostats = $this->get('seostats');
		$url1 = 'http://www.bangyoulater.com';
		print $seostats->Social()->getTwitterShares($url1) . '<br>';
		print $seostats->Alexa()->getGlobalRank($url1) . '<br>';
		return new Response($seostats->Google()->getPageRank($url1));
		
	}
	
	
}
