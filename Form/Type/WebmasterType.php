<?php

namespace Shaythamc\LinkManagementBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WebmasterType extends AbstractType{
	
	public function buildForm(FormBuilderInterface $builder, array $options){
		
		$builder->add('name', 'text', array('required' => true))
				->add('email', 'text', array('required' => false))
				->add('phone', 'text', array('required' => false))
				->add('skype', 'text', array('required' => false))
				->add('icq', 'text', array('required' => false))
				->add('forum', 'text', array('required' => false))
				->add('forumUser', 'text', array('required' => false))
				->add('paymentMethod', 'text', array('required' => false))
				->add('paymentDetails', 'text', array('required' => false))
				->add('notes', 'text', array('required' => false))
				->getForm();
	}
	
	public function getName(){
		return 'webmaster';
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver){
		$resolver->setDefaults(
			array(
				'data_class' => 'Shaythamc\LinkManagementBundle\Entity\Webmaster',
			)
		);
	}
	
	
	
}
