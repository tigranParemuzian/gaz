<?php

namespace Gaz\MainBundle\Form;

use Gaz\MainBundle\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;

class CompanyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'Add name'))
            ->add('code', null, array('label' => 'Add Code'))
            ->add('paymentTypes', 'choice', array(
				'choices' => array(
					Company::FREE =>'free',
					Company::CASH => 'cash',
					Company::TRANSFER => 'transfer'
				),
				'attr' => array(
					'class' => 'browser-default'), 'label' => 'Select payment type'))
            ->add('groupType', 'choice', array(
					'choices' => array(
						Company::CITIZEN =>'Citizen',
						Company::COMPANY => 'Company',
						Company::WORKER => 'Worker',
						Company::DIRECTOR => 'Director'
					),
					'attr' => array(
						'class' => 'browser-default'), 'label' => 'Select Group type'))
            ->add('percent', null)
            ->add('depositLimit', null)
			->add('save', 'submit', array('label' => 'Save order'))
        ;
    }

//

	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Gaz\MainBundle\Entity\Company'
		));
	}

    /**
     * @return string
     */
    public function getName()
    {
        return 'gaz_main_company';
    }
}
