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

class CompanyAdmin extends Admin
{

	/**
	 * @param DatagridMapper $datagridMapper
	 */
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper
			->add('id', null, array('label' => 'id'))
			->add('name', null, array('label' => 'Name'))
			->add('code', null, array('label' => 'Code'), 'password')
			->add('groupType', null, array('label' => 'Group Type'))
			->add('paymentTypes', null, array('label' => 'Payment Type'))
			->add('percent', null, array('label' => 'Percent'))
			->add('depositLimit', null, array('label' => 'Deposit Limit'))
			->add('client', null, array('label' => 'Client'))
		;
	}

	/**
	 * @param ListMapper $listMapper
	 */
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
			->add('id', null, array('label' => 'id'))
			->add('name', null, array('label' => 'Name'))
			->add('code', null, array('label' => 'Code'))
			->add('groupType', null, array('label' => 'Group Type'))
			->add('paymentTypes', null, array('label' => 'Payment Type'))
			->add('percent', null, array('label' => 'Percent'))
			->add('depositLimit', null, array('label' => 'Deposit Limit'))
			->add('client', null, array('label' => 'Client'))
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
			->add('groupType', 'choice', array('choices'=>array(
				3=>'աշղատող', 4=>'կազմակերպություն', 5=>'քաղաքացի', 6=>'տնօրեն' ), 'label' => 'Խմբի տեսակը'))
			->add('paymentTypes', 'choice', array('choices'=>array(
				0=>'անվճար', 1=>'փոխանցումով', 2=>'կանղիկ' )))
			->add('percent', null, array('label' => 'Percent'))
			->add('depositLimit', null, array('label' => 'Deposit Limit'))
			->add('client', null, array('label' => 'Client'))
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
			->add('id', null, array('label' => 'id'))
			->add('name', null, array('label' => 'Name'))
			->add('code', null, array('label' => 'Code'))
			->add('groupType', null, array('label' => 'Group Type'))
			->add('paymentTypes', null, array('label' => 'Payment Type'))
			->add('percent', null, array('label' => 'Percent'))
			->add('depositLimit', null, array('label' => 'Deposit Limit'))
			->add('client', null, array('label' => 'Client'))
		;
	}
}