<?php

namespace Shaythamc\LinkManagementBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class CheckerCommand extends ContainerAwareCommand{
    
    protected function configure(){
        $this->setName('lmt:checker')
             ->setDescription('Check all Sites for GooglePR, AlexaPR and check all Backlinks are valid');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output){
        $backlinkChecker = $this->getContainer()->get('lmt_backlink_checker');
        $backlinkChecker->check();
        
        $siteChecker = $this->getContainer()->get('lmt_site_checker');
        $siteChecker->checkGooglePR();
        $siteChecker->checkAlexaGR();
    }
    
}
