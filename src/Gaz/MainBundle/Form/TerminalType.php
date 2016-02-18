<?php

namespace Gaz\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TerminalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

		$builder
			->add('number', 'number', array('label'=>'Number'))
			->add('station', 'entity', array(
				'class' => 'GazMainBundle:Station',
				'choice_label' => 'Number',
				'placeholder' => 'Choose an Station',
				'label'=>'Station', 'required'=>true,
				'attr'=>array('class'=>'form-control')))
			->add('save', 'submit', array('label' => 'Save Terminal'))
		;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
		$resolver->setDefaults(array(
			'data_class' => 'Gaz\MainBundle\Entity\Terminal'
		));
    }

    public function getName()
    {
        return 'gaz_main_bundle_terminal_type';
    }
}
