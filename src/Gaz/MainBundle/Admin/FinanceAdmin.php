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

class FinanceAdmin extends Admin
{

	/**
	 * @param DatagridMapper $datagridMapper
	 */
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper
			->add('id', null, array('label' => 'Հ/հ'))
			->add('created', 'doctrine_orm_datetime_range', array('field_type'=>'sonata_type_datetime_range_picker', 'label' => 'Ամսաթիվ'), null, array(
				'widget' => 'single_text',
				'format' => 'yyyy-MM-dd HH:mm:ss',
				'required' => false,
				'attr' => array('class' => 'datetimepicker')
			))
			->add('price', null, array('label' => 'Գումր'))
			->add('deposit', null, array('label' => 'Կուտակվել է'))
			->add('residue', null, array('label' => 'Կլորացում'))
			->add('financeType', null, array('label' => 'Վճ․ տեսակ'), 'choice',
				array('choices' => array(
					1 => 'Հաշվառված',
					2 => 'Չհաշվառված'
				)))
			->add('clientSale', null, array('label' => 'Վաճառող'))
			->add('clientBuy', null, array('label' => 'Գնորդ'))
			->add('terminal', null, array('label' => 'Լցակետ'))
			->add('station', null, array('label' => 'Լցակայան'))
		;
	}

	/**
	 * @param ListMapper $listMapper
	 */
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
			->add('id', null, array('label' => 'Հ/հ'))
			->add('price', null, array('label' => 'Գումր'))
			->add('deposit', null, array('label' => 'Կուտակվել է'))
			->add('residue', null, array('label' => 'Կլորացում'))
			->add('financeType', null, array('label' => 'Վճ․ տեսակ', 'editable' => true))
			->add('created', null, array('label' => 'Ամսաթիվ'))
			->add('clientSale', null, array('sortable' => 'clientSale.name', 'label' => 'Վաճառող'))
			->add('clientBuy', null, array('sortable' => 'clientBuy.name', 'label' => 'Գնորդ'))
			->add('terminal', null, array('sortable' => 'terminal.number', 'label' => 'Լցակետ'))
			->add('station', null, array('sortable' => 'station.number','label' => 'Լցակայան'))
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
			->add('price', null, array('label' => 'Գումր'))
			->add('deposit', null, array('label' => 'Կուտակվել է'))
			->add('residue', null, array('label' => 'Կլորացում'))
			->add('financeType', null, array('label' => 'Վճ․ տեսակ'))
			->add('created', null, array('label' => 'Ամսաթիվ'))
			->add('clientSale', null, array('label' => 'Վաճառող'))
			->add('clientBuy', null, array('label' => 'Գնորդ'))
			->add('terminal', null, array('label' => 'Լցակետ'))
			->add('station', null, array('label' => 'Լցակայան'))
		;
	}

	/**
	 * @param ShowMapper $showMapper
	 */
	protected function configureShowFields(ShowMapper $showMapper)
	{
		$showMapper
			->add('price', null, array('label' => 'Գումր'))
			->add('deposit', null, array('label' => 'Կուտակվել է'))
			->add('residue', null, array('label' => 'Կլորացում'))
			->add('financeType', null, array('label' => 'Վճ․ տեսակ'))
			->add('created', null, array('label' => 'Ամսաթիվ'))
			->add('clientSale', null, array('label' => 'Վաճառող'))
			->add('clientBuy', null, array('label' => 'Գնորդ'))
			->add('terminal', null, array('label' => 'Լցակետ'))
			->add('station', null, array('label' => 'Լցակայան'))
		;
	}
}