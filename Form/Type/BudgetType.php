<?php

namespace Shaythamc\LinkManagementBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BudgetType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        
        $builder->add('name', 'text')
                ->add('initial', 'text')
                ->getForm();
    }
    
    public function getName(){
       return 'Budget'; 
    }  
    
    public function setDefaultOptions(OptionsResolverInterface $resolver){
		$resolver->setDefaults(
			array(
				'data_class' => 'Shaythamc\LinkManagementBundle\Entity\Budget',
			)
		);
	}
    
    
}
