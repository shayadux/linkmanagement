<?php

namespace Shaythamc\LinkManagementBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Shaythamc\LinkManagementBundle\Entity\Site;
use Shaythamc\LinkManagementBundle\Form\Type\SiteType;

use Shaythamc\LinkManagementBundle\Entity\Backlink;
use Shaythamc\LinkManagementBundle\Form\Type\BacklinkType;

use Shaythamc\LinkManagementBundlle\Entity\Transaction;

class SiteController extends Controller{
	
	/**
	 * Add a site
	 */
	public function addSiteAction(Request $request){
		$site = new Site();

		$form = $this->createForm(new SiteType(), $site);
		
		if($request->isMethod('POST')){
			
			$form->bind($request);
			$siteManager = $this->get('lmt_site_manager');
			$siteArray = get_object_vars($site);
			$siteManager->addSite($siteArray);
            
            if($site->getActive()){
                $budgetManager = $this->get('lmt_budget_manager'); 
                $amount = floatval($site->getPrice());
                var_dump($budgetManager->withdraw($site->getBudgetId(), $amount));
            }
		}
		
		return $this->render('ShaythamcLinkManagementBundle:Site:add.html.twig', array(
			'form' => $form->createView(),
		));
	}
	
	/**
	 * Edit a site
	 */
	public function editSiteAction(Request $request, $siteId){
			
		$site = new Site();
		
		$siteManager = $this->get('lmt_site_manager');
		
		$siteInfo = $siteManager->getSite($siteId);
		
		$site->setSiteId($siteInfo['siteId']);
		$site->setTitle($siteInfo['title']);
		$site->setUrl($siteInfo['url']);
		$site->setKeyword($siteInfo['keyword']);
		$site->setPageFound($siteInfo['page_found']);
		$site->setSource($siteInfo['source']);
		$site->setNotes($siteInfo['notes']);
		$site->setWebmasterId((int) $siteInfo['webmasterId']);
		
		var_dump($siteInfo);

		$form = $this->createForm(new SiteType(), $site);
		
		if($request->isMethod('POST')){
			
			$form->bind($request);
			
			if($request->request->get('_delete')){		
				$siteManager->deleteSite($siteId);
				return $this->redirect($this->generateUrl('shaythamc_link_management_homepage'));
			}
			else{
				$siteArray = get_object_vars($site);
				$siteManager->editSite($siteId, $siteArray);
				return $this->redirect($this->generateUrl('shaythamc_link_management_view_all_sites'));
			}
		}
		
		return $this->render('ShaythamcLinkManagementBundle:Site:edit.html.twig', array(
            'form' => $form->createView(),
            'siteId' => $siteId,
        ));
	}
	
	/**
	 * View all sites
	 */
	public function viewAllSitesAction(Request $request){
		
		$siteManager = $this->get('lmt_site_manager');
			
		$allSites = $siteManager->getAllSites();
		
		// Check if there are any sites in the Sites table
		if(!$allSites){
			return new Response('no sites to list');
		}
		else{
			
//			// Instantiate the SEOstats service
//			$seostats = $this->get('seostats');
//			
//			foreach($allSites as $key => $value){
//				
//				$url = $allSites[$key]['url'];
//				$allSites[$key]['pagerank'] = $seostats->Google()->getPageRank($url);
//				$allSites[$key]['globalrank'] = $seostats->Alexa()->getGlobalRank($url);
//			}
						
			$form = $this->createFormBuilder()->getForm();
		}
		
		if($request->isMethod('POST')){
			
			$form->bind($request);
			
			if($request->request->get('_delete')){
				$siteManager->deleteSite($request->request->get('siteId'));
				return $this->redirect($this->generateUrl('shaythamc_link_management_view_all_sites'));
			}
			elseif($request->request->get('_edit')){
				$siteId = $request->request->get('siteId');
				return $this->redirect($this->generateUrl('shaythamc_link_management_edit_site', array('siteId' => $siteId)));
			}
		}
		
		
		
		return $this->render('ShaythamcLinkManagementBundle:Site:all.html.twig', array(
            'form' => $form->createView(),
            'sites' => $allSites,
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
