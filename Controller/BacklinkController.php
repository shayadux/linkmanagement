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

use Shaythamc\LinkManagementBundle\Entity\Transaction;

class BacklinkController extends Controller{

    /**
     * Add a backlink
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
	public function addBacklinkAction(Request $request){

        // Create a new instance of the Backlink class
		$backlink = new Backlink();

        // 
		$form = $this->createForm(new BacklinkType(), $backlink);

		if($request->isMethod('POST')){
			$form->bind($request);
			$backlinkManager = $this->get('lmt_backlink_manager');
			$backlinkArray = get_object_vars($backlink);
            $backlinkManager->addBacklink($backlinkArray);
		}

		return $this->render('ShaythamcLinkManagementBundle:Backlink:add.html.twig', array(
			'form' => $form->createView(),
		));
	}

    /**
     * View all the backlinks
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
	public function viewAllBacklinksAction(Request $request){

        // Make the BacklinkChecker service available
		$backlinkManager = $this->get('lmt_backlink_manager');

        // Get all the backlinks
		$backlinks = $backlinkManager->getAllBacklinks();

        // Go through every backlink
        foreach($backlinks as $key => $blink){

            // Get the siteId associated with the current backlink
            $site = $backlinkManager->getBacklinkSite($blink['siteId']);

            // Add the associated site's URL to the backlink array
            $backlinks[$key]['siteUrl'] = $site['url'];

            // Add the associated site's title to the backlink array
            $backlinks[$key]['siteName'] = $site['title'];
       }

       // Render the view
       return $this->render('ShaythamcLinkManagementBundle:Backlink:all.html.twig', array(
			'backlinks' => $backlinks,
       ));

	}
}
