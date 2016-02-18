<?php

namespace Gaz\MainBundle\Form;

use Gaz\MainBundle\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'integer', array('label'=>'number', 'required'=>false))
            ->add('terminal', 'integer', array('label'=>'Terminal', 'required'=>false))
            ->add('buyer', 'text', array('label'=>'Client name', 'required'=>false))
            ->add('worker', 'text', array('label'=>'Worker name', 'required'=>false))
            ->add('price', 'integer', array('label'=>'Price', 'required'=>false))
            ->add('balance', 'integer', array('label'=>'Balance', 'required'=>false))
            ->add('deposit', 'integer', array('label'=>'Deposit', 'required'=>false))
            ->add('residue', 'integer', array('label'=>'Residue', 'required'=>false))
            ->add('created', 'datetime', array('widget' => 'choice',
				'format' => 'dd-MM-yyyy H:i',
					'attr'=>array('class'=>'datepicker'),
					 'required'=>false))
			->add('save', 'submit', array('label' => 'Filter', 'attr' => array('class'=>'btn waves-effect waves-light')))
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gaz_filter';
    }
}
