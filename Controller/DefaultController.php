<?php

namespace Shaythamc\LinkManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Shaythamc\LinkManagementBundle\Service\BacklinkChecker;

class DefaultController extends Controller
{
    public function indexAction()
    {
        
    
        $backlinkChecker = $this->get('lmt_backlink_checker');
//        echo $backlinkChecker->checkDisplayText();
        $areAlive = $backlinkChecker->areAlive();
        //return new Response($isAlive);
        
        return $this->render('ShaythamcLinkManagementBundle:Default:index.html.twig');
        
    }
    
    
}
