<?php
/**
 * Created by PhpStorm.
 * User: tigran
 * Date: 7/30/15
 * Time: 10:45 AM
 */
namespace Gaz\MainBundle\Admin;

use Gaz\MainBundle\Entity\Client;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ClientAdmin extends Admin
{

	/**
	 * @param DatagridMapper $datagridMapper
	 */
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper
			->add('id', null, array('label' => 'id'))
			->add('code', null, array('label' => 'Code'), 'password')
			->add('name', null, array('label' => 'Name'))
			->add('lastName', null, array('label' => 'Last Name'))
			->add('careNumber', null, array('label' => 'Care Number'))
			->add('phone', null, array('label' => 'Phone'))
			->add('depositLimit', null, array('label' => 'Deposit Limit'))
			->add('percent', null, array('label' => 'Percent'))
			->add('paymentTypes', null, array('label' => 'Payment Types'))
			->add('company', null, array('label' => 'Company'))
		;
	}

	/**
	 * @param ListMapper $listMapper
	 */
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
			->add('id', null, array('label' => 'id'))
			->addIdentifier('code', null, array('label' => 'Code'))
			->add('name', null, array('label' => 'Name'))
			->add('lastName', null, array('label' => 'Last Name'))
			->add('careNumber', null, array('label' => 'Care Number'))
			->add('phone', null, array('label' => 'Phone'))
			->add('company', null, array('label' => 'Company'))
			->add(
				'_action',
				'actions',
				array(
					'actions' => array(
						'show' => array(),
						'edit' => array(),
						'delete' => array(),
					)
				)
			);
	}

	/**
	 * @param FormMapper $formMapper
	 */
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
		->tab('General')
			->with('General')
			->add('name', null, array('label' => 'Name'))
			->add('lastName', null, array('label' => 'Last Name'))
			->add('careNumber', null, array('label' => 'Care Number'))
			->add('phone', null, array('label' => 'Phone'))
			->add('depositLimit', null, array('label' => 'Deposit Limit'))
			->add('percent', null, array('label' => 'Percent'))
			->add('paymentTypes', 'choice', array('choices'=>array(
				0=>'free', 1=>'trans', 2=>'cash' )))
			->add('company', null, array('label' => 'Company'))
			->end()
		->end()
		->tab('Code')
			->with('Code')
			->add('code', 'password', array('label' => 'Code'))
			->end()
		->end()
		;
	}

	/**
	 * @param ShowMapper $showMapper
	 */
	protected function configureShowFields(ShowMapper $showMapper)
	{
		$showMapper
			->add('counte', null, array('label' => 'Count'))
			->add('price', null, array('label' => 'Price'))
			->add('balance', null, array('label' => 'Balance'))
			->add('cache', null, array('label' => 'Cache'))
			->add('status', null, array('label' => 'Status'))
			->add('terminal', null, array('label' => 'Terminal'))
		;
	}

	/**
	 * {@inheritdoc}
	 */
	public function prePersist($object)
	{
		$object->setCreated(new \DateTime('now'));
	}

}