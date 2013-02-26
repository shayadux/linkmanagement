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
    
    public function __construct(BacklinkManager $backlinkManager, SiteManager $siteManager, BacklinkChecker $backlinkChecker, BudgetManager $budgetManager){
        
        $this->backlinkManager = $backlinkManager;
        $this->siteManager = $siteManager;
        $this->backlinkChecker = $backlinkChecker;
        $this->budgetManager = $budgetManager;
        
        
        
    }
    
    public function checkAllUrlStatus(){
        
        $urlStatus = $this->backlinkManager->getAllBacklinkUrlStatus();
        
        var_dump($urlStatus);
        
        
    }
    
    public function checkAllAnchorStatus(){
        
        
        
        
    }
    
    public function checkNofollowStatus(){}
    
    public function checkVisibleStatus(){}
    
    public function checkBudget(){}
    
    public function notify(){}
    
    
}