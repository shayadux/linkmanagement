<?php

namespace Shaythamc\LinkManagementBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Shaythamc\LinkManagementBundle\Form\WebmasterChoiceList;
use Shaythamc\LinkManagementBundle\Form\BudgetChoiceList;


class SiteType extends AbstractType{
	
	public function buildForm(FormBuilderInterface $builder, array $options){
		
		$builder->add('title', 'text', array('required' => true))
				->add('url', 'text')
                ->add('price', 'text')
				->add('keyword', 'text')
				->add('pageFound', 'integer')
				->add('source', 'text')
				->add('notes', 'text')
				//~ ->add('webmasterId', 'integer')
				->add('webmasterId', 'choice', array(
					'choice_list' => new WebmasterChoiceList(),
				))
                ->add('budgetId', 'choice', array(
					'choice_list' => new BudgetChoiceList(),
				))
                ->add('active', 'checkbox', array('required' => false))
				->getForm();
		}
		
	public function getName(){
		return 'site';
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver){
		$resolver->setDefaults(
			array(
				'data_class' => 'Shaythamc\LinkManagementBundle\Entity\Site',
			)
		);
	}
}
