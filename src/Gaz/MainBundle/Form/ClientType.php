<?php

namespace Gaz\MainBundle\Form;

use Gaz\MainBundle\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code')
            ->add('name')
            ->add('lastName')
            ->add('careNumber')
            ->add('phone')
            ->add('depositLimit')
            ->add('percent')
			->add('paymentTypes', 'choice', array(
				'choices' => array(
					Client::FREE =>'free',
					Client::CASH => 'cash',
					Client::TRANSFER => 'transfer'
				),
				'attr' => array(
					'class' => 'browser-default'), 'label' => 'Select payment type'))
            ->add('company', null, array('attr' => array(
				'class' => 'browser-default')))
			->add('save', 'submit', array('label' => 'Save order'))
        ;
    }

	/**
	 * @param OptionsResolver $resolver
	 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gaz\MainBundle\Entity\Client'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gaz_mainbundle_client';
    }
}
