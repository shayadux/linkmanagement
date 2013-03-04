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

	public function addBacklinkAction(Request $request){

		$backlink = new Backlink();

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

	public function viewAllBacklinksAction(Request $request){

		$backlinkManager = $this->get('lmt_backlink_manager');
		$backlinks = $backlinkManager->getAllBacklinks();

        foreach($backlinks as $key => $blink){

            $site = $backlinkManager->getBacklinkSite($blink['siteId']);
            $backlinks[$key]['siteUrl'] = $site['url'];
            $backlinks[$key]['siteName'] = $site['title'];


//            echo '<pre>';
//            var_dump($backlinks);
//            echo '</pre>';

        }



		return $this->render('ShaythamcLinkManagementBundle:Backlink:all.html.twig', array(
			'backlinks' => $backlinks,
		));

	}
}
