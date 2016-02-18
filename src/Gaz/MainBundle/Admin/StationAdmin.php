<?php
/**
 * Created by PhpStorm.
 * User: tigran
 * Date: 7/30/15
 * Time: 10:45 AM
 */
namespace Gaz\MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class StationAdmin extends Admin
{

	/**
	 * @param DatagridMapper $datagridMapper
	 */
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper
			->add('id', null, array('label' => 'id'))
			->add('number', null, array('label' => 'Name'))
		;
	}

	/**
	 * @param ListMapper $listMapper
	 */
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
			->add('id', null, array('label' => 'id'))
			->add('number', null, array('label' => 'Number'))
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
			->with('General')
			->add('number', null, array('label' => 'Number'))
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
			->add('number', null, array('label' => 'Number'))
		;
	}
}