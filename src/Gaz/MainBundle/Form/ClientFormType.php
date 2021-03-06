<?php
/**
 * Created by PhpStorm.
 * User: tigran
 * Date: 8/7/15
 * Time: 10:39 AM
 */
namespace Gaz\MainBundle\Form ;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ClientFormType extends AbstractType
{

	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('cart', 'password', array('label'=>'Enter code', 'required' => true, 'label_attr'=>array('class'=>'hidden') ))
			->add('save', 'submit', array('label' => 'Login', 'attr' => array(
						'class' => 'hidden')))
			;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'cart_login';
	}
}