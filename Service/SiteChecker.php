<?php

namespace Shaythamc\LinkManagementBundle\Service;

class SiteChecker{
    
    private $siteManager;
    private $seostats;
    
    public function __construct(SiteManager $siteManager, Stats $seostats){
        
        $this->siteManager = $siteManager;
        $this->seostats = $seostats;
    }
    
    /**
     * Check the Google PageRank of every site in the Sites table
     */
    public function checkGooglePR(){
        
        // Get all the sites' url and id
        $allSiteUrlWithId = $this->siteManager->getAllSiteUrlWithId();
        
        // Go through every site
        foreach($allSiteUrlWithId as $site){
            
            // Get the pagerank
            $googlePR = $this->seostats->Google()->getPageRank($site['url']);
            
            // Save the pagerank to the sites table
            $this->siteManager->updateGooglePR($googlePR, $site['siteId']);
            
        }
    }
    
    /**
     * Check the Alexa GlobalRank of every site in the Sites table
     */
    public function checkAlexaGR(){
        
        // Get all the sites' url and id
        $allSiteUrlWithId = $this->siteManager->getAllSiteUrlWithId();
        
        // Go through every single site
        foreach($allSiteUrlWithId as $site){
            
            // Get the globalrank from alexa...
            $alexaGR = $this->seostats->Alexa()->getGlobalRank($site['url']);
            
            // then set the globalrank in the sites table
            $this->siteManager->updateAlexaGR($alexaGR, $site['siteId']);
            
        }
    }
    
    
}