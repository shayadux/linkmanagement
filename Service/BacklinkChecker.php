<?php

namespace Shaythamc\LinkManagementBundle\Service;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\CssSelector\CssSelector;
use Symfony\Component\Finder\Finder;
use Guzzle\Service\Client;

use \Exception;

/**
 * Check if the Backlinks are valid
 */
class BacklinkChecker{
    
    protected $backlinkManager;
    protected $siteManager;
    public $backlinks;
    
    public function __construct(BacklinkManager $backlinkManager, SiteManager $siteManager){
        
        // Load the BacklinkManager and SiteManager
        $this->backlinkManager = $backlinkManager;
        $this->siteManager = $siteManager;
    }
        
    public function check(){
        
        // Get all the backlink url's
        $this->backlinks = $this->backlinkManager->getAllBacklinkUrls();
    
        // Get all the backlinks
        $backlinks = $this->backlinks;
        
        // Go through every backlink...
        foreach($backlinks as $key => $backlink){
            
            // Get the site associated with the current backlink
            $siteUrl = $this->siteManager->getSiteUrl($backlink['siteId']);
            
            // Request the contents of the affiliate web page
            $client = new Client($siteUrl['url']);
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
                
                // Check to see if the URL matches our backlinkURL
                if($this->checkUrl($backlink['backlinkId'], $checkArray[0])){
                    
                    // If true, then update the url_status to 1 
                    $this->backlinkManager->updateUrlStatus($backlink['backlinkId'], 1);
                    
                    // Check if the backlink has the right anchor text
                    if($this->checkDisplayText($backlink['backlinkId'], $checkArray[1])){

                        // If true, then update the anchor_status to 1
                        $this->backlinkManager->updateAnchorStatus($backlink['backlinkId'], 1);
                        
                        // Also keep a copy of their anchor text for manual verification anyway
                        $this->storeAnchorText($backlink['backlinkId'], $checkArray[1]);
                    }
                    else{ 
                    // If anchor text doesn't match...
                        
                        // Store the anchor text for manual verification
                        $this->storeAnchorText($backlink['backlinkId'], $checkArray[1]);
                        
                        // Update the anchor_status to 0
                        $this->backlinkManager->updateAnchorStatus($backlink['backlinkId'], 0);
                    }
                    
                    // Check if there is a rel="nofollow" attribute
                    if($this->checkNofollow($backlink['backlinkId'], $checkArray[2])){
                        
                        // If true, then update the nofollow_status to 0
                        $this->backlinkManager->updateNofollowStatus($backlink['backlinkId'], 0);
                    }
                    else{ 
                    // Otherwise, there is a "nofollow"...
                        
                        // ...and we update the nofollow_status to 1
                        $this->backlinkManager->updateNofollowStatus($backlink['backlinkId'], 1);
                    }
                    
                    // Tell the console the link has been checked
                    echo '-->CHECKED BACKLINK WITH ID# ' . $backlink['backlinkId'] . PHP_EOL;
                    
                    break;
                }
                else{
                    // No matches found so set url_status, anchor_status, nofollow_status to 0
                    $this->backlinkManager->updateUrlStatus($backlink['backlinkId'], 0);
                    $this->backlinkManager->updateAnchorStatus($backlink['backlinkId'], 0);
                    $this->backlinkManager->updateNofollowStatus($backlink['backlinkId'], 0);
                }
            }
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
        //if(strcasecmp(rtrim($backlinkUrl, '/'), rtrim(filter_var($url, FILTER_VALIDATE_URL), '/')) === 0){
        
        // Keeping it simple for now...
        if(strcasecmp($backlinkUrl, $url) === 0){    
            return true;
        }

        return false;
    }
    
    /**
     * Check if the specified display text matches the link affiliates anchor text
     * @param type $backlinkId
     * @param type $anchorText
     * @return boolean
     */
    public function checkDisplayText($backlinkId, $anchorText){
        
        // Get the specified display text from the Backlinks table
        $backlinkDisplayText = $this->backlinkManager->getBacklinkDisplayText($backlinkId);
        
        // Do a string comparison to see if they match
        if(strcasecmp($backlinkDisplayText, $anchorText) == 0){
            return true;
        }
        
        return false;
    }
    
    /**
     * Store the affiliates anchor text for verification purposes
     * @param type $backlinkId
     * @param type $anchorText
     */
    public function storeAnchorText($backlinkId, $anchorText){
        // Store the anchor text in the Backlinks table
        $this->backlinkManager->updateAnchorText($backlinkId, $anchorText);
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
            return false;
        }
        
        return true;
    }   
}