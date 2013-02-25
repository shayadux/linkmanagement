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
    
    public function areAlive(){
        
        // Get all the backlinks
        $backlinks = $this->backlinks;
        
        // Go through every backlink...
        foreach($backlinks as $key => $backlink){
            
            // Get the site associated with the current backlink
            $siteUrl = $this->siteManager->getSiteUrl($backlink['siteId']);
            
            // Request the contents of the affiliate web page
            $client = new Client($siteUrl[0]['url']);
            $httpRequest = $client->get();
            $httpResponse = $httpRequest->send();
            
            // Convert the page's contents to a string
            $html = (string) $httpResponse->getBody();
            
            // Use symfonys crawler component to look through the page
            $crawler = new Crawler($html);
            
            // Specify which attributes we want to look at, and collect those values as an array
            $attributes = $crawler->filter('a')->extract(array('href', '_text', 'rel'));
            
            // Go through every single value we collected so we can...
            foreach($attributes as $checkArray){
                
                // ...check if our specified URL is on their page
                if($this->checkUrl($backlink['backlinkId'], $checkArray[0])){
                    // ...check if they have the anchor text we want
                    if($this->checkDisplayText($backlink['backlinkId'], $checkArray[1])){
                        // and finally make sure they aren't screwing us over with rel="nofollow"
                        if($this->checkNofollow($backlink['backlinkId'], $checkArray[2])){
                            return true;
                        }
                    }
                }
            }
        }
    }
    
    /**
     * Check if the specified display text matches the link affiliates anchor text
     * @param type $backlinkId
     * @param type $anchorText
     * @return boolean
     */
    public function checkDisplayText($backlinkId, $anchorText){
        
        $backlinkDisplayText = $this->backlinkManager->getBacklinkDisplayText($backlinkId);
                
        if(strcasecmp($backlinkDisplayText, $anchorText) == 0){
            $this->backlinkManager->updateAnchorStatus($backlinkId, 1);
            return true;
            
        }
        else{
            $this->backlinkManager->updateAnchorStatus($backlinkId, 0);
            return false;
        }
    }
    
    /**
     * Check the retrieved URL against the one we have specified in the Backlinks table
     * @param type $backlinkId
     * @param type $url
     * @return boolean
     */
    public function checkUrl($backlinkId, $url){
        
        $backlinkUrl = $this->backlinkManager->getBacklinkUrl($backlinkId);
        
        // Validate the retrieved URL
        // Trim a trailing slash from both URL's (rtrim)
        // Non case-senitive string comparison of the URL's
        if(strcasecmp(rtrim($backlinkUrl, '/'), rtrim(filter_var($url, FILTER_VALIDATE_URL), '/')) === 0){
            $this->backlinkManager->updateUrlStatus($backlinkId, 1);
            return true;
        }
        else{
            $this->backlinkManager->updateUrlStatus($backlinkId, 0);
            return false;
        }
    }
    
    
    /**
     * Check if the rel attribute is set to nofollow
     * @param type $backlinkId
     * @param type $nofollow
     * @return boolean
     */
    public function checkNofollow($backlinkId, $nofollow){
        
//        // Convert the string to all lowercase 
//        $nofollow = strtolower(trim($nofollow));
//        
//        // The rel attribute can have multipe values seperated by a space
//        // If that is the case, we explode them into an array
//        $nofollowArray = explode(' ', $nofollow);
//        
//        // See if 'nofollow' is in the array
//        if(in_array('nofollow', $nofollowArray)){
//            
//            // Get the array key for the value 'nofollow'
//            $nofollowKey = array_search('nofollow', $nofollowArray);
//            
//            // Save the value into our initial $nofollow variable
//            $nofollow = $nofollowArray[$nofollowKey];
//        }
        
        if($nofollow == 'nofollow'){
            $this->backlinkManager->updateNofollowStatus($backlinkId, 0);
            return false;
        }
        else{
            $this->backlinkManager->updateNofollowStatus($backlinkId, 1);
            return true;
        }
    }

       

    
}
