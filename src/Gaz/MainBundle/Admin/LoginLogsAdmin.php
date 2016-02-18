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

class LoginLogsAdmin extends Admin
{

	/**
	 * @param DatagridMapper $datagridMapper
	 */
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper
			->add('id', null, array('label' => 'id'))
			->add('loginTime', null, array('label' => 'Login Time'))
			->add('logoutTime', null, array('label' => 'logout Time'))
			->add('worker', null, array('label' => 'Worker'))
		;
	}

	/**
	 * @param ListMapper $listMapper
	 */
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
			->add('id', null, array('label' => 'id'))
			->add('loginTime', null, array('label' => 'Login Time'))
			->add('logoutTime', null, array('label' => 'logout Time'))
			->add('worker', null, array('label' => 'Worker'))
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
			->add('id', null, array('label' => 'id'))
			->add('loginTime', null, array('label' => 'Login Time'))
			->add('logoutTime', null, array('label' => 'logout Time'))
			->add('worker', null, array('label' => 'Worker'))
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
			->add('loginTime', null, array('label' => 'Login Time'))
			->add('logoutTime', null, array('label' => 'logout Time'))
			->add('worker', null, array('label' => 'Worker'))
		;
	}
}