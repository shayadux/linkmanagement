<?php

namespace Shaythamc\LinkManagementBundle\Service;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\CssSelector\CssSelector;
use Symfony\Component\Finder\Finder;
use Guzzle\Service\Client;

use \Exception;

class BacklinkChecker{
    
    protected $backlinkManager;
    protected $siteManager;
    public $backlinks;
    
    public function __construct(BacklinkManager $backlinkManager, SiteManager $siteManager){
        $this->backlinkManager = $backlinkManager;
        $this->backlinks = $this->backlinkManager->getAllBacklinkUrls();
        
        $this->siteManager = $siteManager;
    }
    
    public function isAlive(){
        
        $client = new Client('http://www.wtfpeople.com/');
        $httpRequest = $client->get();
        $httpResponse = $httpRequest->send();
        
        $html = (string) $httpResponse->getBody();
        
        $crawler = new Crawler($html);
        
        $attributes = $crawler
                        ->filter('a')
                        ->extract(array('href', '_text', 'rel'));
        				
		foreach($attributes as $linkarray){
			
            if($linkarray[1] == 'Free Porn'){
                if($linkarray[0] == 'http://www.bangyoulater.com'){
                   if($linkarray[2] == 'nofollow'){
                       echo 'links no good';
                   }
                   else{
                       echo $linkarray[1] . $linkarray[0] . $linkarray[2];
                   }
                }
            }
		}
		
		
		return true;
        
    }
    
    public function areAlive(){
        
        $backlinks = $this->backlinks;
        
        
        foreach($backlinks as $key => $backlink){
            
            echo $backlink['display_text'];
            
            $siteUrl = $this->siteManager->getSiteUrl($backlink['siteId']);
            
            var_dump($siteUrl[0]['url']);
            
            $client = new Client($siteUrl[0]['url']);
            $httpRequest = $client->get();
            $httpResponse = $httpRequest->send();
            
            $html = (string) $httpResponse->getBody();
            
            $crawler = new Crawler($html);
            
            $attributes = $crawler->filter('a')->extract(array('_text', 'href', 'rel')); 
            
            foreach($attributes as $checkArray){
                if($checkArray[0] == $backlink['display_text']){
                    
                    $this->backlinkManager->updateAnchorStatus($backlink['backlinkId'], 1);
                    
//                    if($checkArray[1] == $backlink['url']){
//                        
//                        $this->checkNofollow($backlink['backlinkId'], $checkArray[2]);
//                        
//                        
//                    }
//                    else{
//                        echo 'wrong URL';
//                    }
                }
                else{
                    $this->backlinkManager->updateAnchorStatus($backlink['backlinkId'], 0);
                }
            }
            

        }      
        
        
    }
    
    /**
     * Check if the specified display text matches the link affiliates anchor text
     * @param type $backlinkId
     * @param type $anchorText
     */
    public function checkDisplayText($backlinkId, $anchorText){
        
        $backlink = $this->backlinkManager->getBacklinkDisplayText($backlinkId);
        
        $backlinkDisplayText = $backlink[0]['display_text'];
        
        if(strcasecmp($backlinkDisplayText, $anchorText)){
            $this->backlinkManager->updateAnchorStatus($backlinkId, 1);
            
        }
        else{
            $this->backlinkManager->updateAnchorStatus($backlinkId, 0);
        }
        
        
    }
    
    /**
     * Check if the rel attribute is set to nofollow
     * @param type $backlinkId
     * @param type $nofollow
     * @return boolean
     */
    public function checkNofollow($backlinkId, $nofollow){
        
        $nofollow = strtolower(trim($nofollow));
       
        if($nofollow == 'nofollow'){
            $this->backlinkManager->updateNofollowStatus($backlinkId, 0);
            return false;
        }
        else{
            $this->backlinkManager->updateNofollowStatus($backlinkId, 1);
            return true;
        }
    }

       
    public function checkUrl($backlinkId, $url){
        if(!filter_var($url, FILTER_VALIDATE_URL)){
			throw new Exception('Not a valid URL');
		}
    }
    
    
}
