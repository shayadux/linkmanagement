<?php

namespace Shaythamc\LinkManagementBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class CheckerCommand extends ContainerAwareCommand{

    protected function configure(){
        // Set the name of our tool
        // call it using " php app/console lmt:checker "
        // inside the path /var/www/symf/ (for local version)
        $this->setName('lmt:checker')
            // Give a description of what this console app does
             ->setDescription('Check all Sites for GooglePR, AlexaPR and check all Backlinks are valid');
    }

    protected function execute(InputInterface $input, OutputInterface $output){

        // Make the BacklinkChecker service available
        $backlinkChecker = $this->getContainer()->get('lmt_backlink_checker');

        // Check all the backlinks
        $backlinkChecker->check();

        // Make the SiteChecker service available
        $siteChecker = $this->getContainer()->get('lmt_site_checker');

        // DISABLED because Google's getting suspicious
        // Check every sites PageRank and GlobalRank
        //$siteChecker->checkGooglePR();
        //$siteChecker->checkAlexaGR();
    }

}
