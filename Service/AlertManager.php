<?php

namespace Shaythamc\LinkManagementBundle\Service;

/**
 * The AlertManager gives us notifications when
 *  - Something is wrong with a backlink (URL, Anchor, Nofollow, Visible status)
 *  - The budget is low
 *  - A site is about to expire
 */
class AlertManager{
    
    private $backlinkManager;
    private $siteManager;
    private $backlinkChecker;
    private $budgetManager;
    
    protected $backlinkAnchorStatus;
    protected $backlinkNoFollowStatus;
    protected $backlinkVisibleStatus;
    
    public $urlStatusArray = array();
    public $anchorStatusArray = array();
    public $nofollowStatusArray = array();
    public $visibleStatusArray = array();
    
    public $budgetStatusArray = array();
    
    
    public function __construct(BacklinkManager $backlinkManager, SiteManager $siteManager, BacklinkChecker $backlinkChecker, BudgetManager $budgetManager){
        
        $this->backlinkManager = $backlinkManager;
        $this->siteManager = $siteManager;
        $this->backlinkChecker = $backlinkChecker;
        $this->budgetManager = $budgetManager;
        
        $this->urlStatus();
        $this->anchorStatus();
        $this->nofollowStatus();
        
        $this->budgetStatus();
        
        $this->notify();
    }
    
    /**
     * Collect the URL status of all the backlinks
     */
    public function urlStatus(){
        
        // Retrieve the url_status and backlinkId from the Backlinks table
        $allBacklinkUrlStatus = $this->backlinkManager->getAllBacklinkUrlStatus();
        
        // Go through every element of the result set
        foreach($allBacklinkUrlStatus as $key => $urlStatusInfo){
            
            // If any backlink has an url_status = 0... 
            if($urlStatusInfo['url_status'] == 0){
                
                // ...then store it in the urlStatusArray
                array_push($this->urlStatusArray, $urlStatusInfo);
            }
        }
    }
    
    /**
     * Collect the anchor status of all the backlinks
     */
    public function anchorStatus(){
        
        // Retrieve the anchor_status and backlinkId from the Backlinks table
        $allBacklinkAnchorStatus = $this->backlinkManager->getAllBacklinkAnchorStatus();
        
        // Go through every element of the result set
        foreach($allBacklinkAnchorStatus as $key => $anchorStatusInfo){
            
            // If any backlink has an anchor_status = 0...
            if($anchorStatusInfo['anchor_status'] == 0){
                
                // ...then store it in the anchorStatusArray
                array_push($this->anchorStatusArray, $anchorStatusInfo);
            }
        }
    }
    
    /**
     * Collect the nofollow status of all the backlinks
     */
    public function nofollowStatus(){
        
        // Retrieve the nofollow_status and backlinkId from the Backlinks table
        $allBacklinkNofollowStatus = $this->backlinkManager->getAllBacklinkNofollowStatus();
        
        // Go through every element of the result set
        foreach($allBacklinkNofollowStatus as $key => $nofollowStatusInfo){
            
            // If any backlink has a nofollow_status = 1...
            if($nofollowStatusInfo['nofollow_status'] == 1){
                
                // ...then store it in the nofollowStatusArray
                array_push($this->nofollowStatusArray, $nofollowStatusInfo);
            }
        }  
    }
    
    public function visibleStatus(){}
    
    public function budgetStatus(){ 
       $remainingAllBudgets = $this->budgetManager->remainingAllBudgets();
       
       foreach($remainingAllBudgets as $budgetRemaining){   
           $budgetStatusText = $budgetRemaining['name'] . ' has ' . $budgetRemaining['remaining'] . ' remaining.';
           array_push($this->budgetStatusArray, $budgetStatusText);
       }
    }
    
    public function notify(){
        
        $totalCount = count($this->urlStatusArray) + count($this->anchorStatusArray) + count($this->nofollowStatusArray);
        
        echo 'you have ' . $totalCount . ' backlinks that need to be checked. <br>';
        
        foreach($this->budgetStatusArray as $budgetStatus){
            echo $budgetStatus . '<br>';
        }
        
    }
    
    
}