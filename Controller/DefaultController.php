<?php

namespace Shaythamc\LinkManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $alertManager = $this->get('lmt_alert_manager');
        $alertManager->urlStatus();
        
        return $this->render('ShaythamcLinkManagementBundle:Default:index.html.twig');
        
    }
    
    
}
