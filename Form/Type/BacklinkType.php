<?php

namespace Shaythamc\LinkManagementBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Shaythamc\LinkManagementBundle\Form\SiteChoiceList;

class BacklinkType extends AbstractType{
	
	public function buildForm(FormBuilderInterface $builder, array $options){
		
		$builder->add('displayText', 'text')
				->add('url', 'text')
				->add('anchorText', 'text')
				->add('expiration', 'text')
				->add('siteId', 'choice', array(
					'choice_list' => new SiteChoiceList(),
				))

				//~ ->add('siteId', 'choice', array(
					//~ 'choices'   => array('m' => 'Male', 'f' => 'Female'),
					//~ 'required'  => false,
				//~ ))
				->add('alive', 'checkbox', array('required' => false))
				->getForm();
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'Shaythamc\LinkManagementBundle\Entity\Backlink',
        ));
    }

    public function getName(){
        return 'backlink';
    }
	
	
}
