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

class SettingsAdmin extends Admin
{

	/**
	 * @param DatagridMapper $datagridMapper
	 */
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper
			->add('id', null, array('label' => 'Հ/հ'))
			->add('paymentPercent', null, array('label' => 'Աշխատավարձային տոկոս'))
//			->add('percentTransfer', null, array('label' => 'Տոկոսնորի փոխանցւմ'), 'sonata_type_date_picker', array('dp_language' => 'en',
//				'format' => 'MM/dd/yyyy'))
		;
	}

	/**
	 * @param ListMapper $listMapper
	 */
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
			->add('id', null, array('label' => 'Հ/հ'))
			->addIdentifier('paymentPercent', null, array('label' => 'Աշխատավարձային տոկոս'))
			->addIdentifier('percentTransfer', null, array('label' => 'Տոկոսնորի փոխանցւմ'))
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
			->add('paymentPercent', null, array('label' => 'Աշխատավարձային տոկոս'))
			->add('percentTransfer', 'sonata_type_date_picker', array(
				'dp_language' => 'en',
				'format' => 'MM/dd/yyyy',
				'label' => 'Տոկոսնորի փոխանցւմ'))
			->end()
		;
	}

	/**
	 * @param ShowMapper $showMapper
	 */
	protected function configureShowFields(ShowMapper $showMapper)
	{
		$showMapper
			->add('id', null, array('label' => 'Հ/հ'))
			->add('paymentPercent', null, array('label' => 'Աշխատավարձային տոկոս'))
			->add('percentTransfer', null, array('label' => 'Տոկոսնորի փոխանցւմ'))
		;
	}
}