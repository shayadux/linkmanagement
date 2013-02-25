<?php

namespace Shaythamc\LinkManagementBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LinkType extends AbstractType{
	
	public function buildForm(FormBuilderInterface $builder, array $options){
		
		$builder->add('title', 'text', array('required' => true))
				->add('url', 'text')
				->add('webmasterId', 'text')
				->add('keywordNotes', 'text')
				->add('notes', 'text')
				->add('expiration', 'text')
				->add('anchorText', 'text')
				->add('price', 'text')
				->add('active', 'checkbox', array('required' => false))
				->getForm();
		}
		
	public function getName(){
		return 'link';
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver){
		$resolver->setDefaults(
			array(
				'data_class' => 'Shaythamc\LinkManagementBundle\Entity\Link',
			)
		);
	}
}
