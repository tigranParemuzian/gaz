<?php

namespace Gaz\MainBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{

    public function topMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->addChild('Admin')->setUri('#');
        $menu['Admin']->addChild('Admin list', array('route' => 'company_list', 'routeParameters' => array('status', 1)));
        $menu['Admin']->addChild('Filter list', array('route' => 'list_filter'));
		$menu->addChild('Company list')
		->setUri('#');

		$menu['Company list']->addChild('Company list', array('route' => 'company_list'));
        $menu['Company list']->addChild('Company create', array('route' => 'create_company'));
        $menu->addChild('Client')->setUri('#');
        $menu['Client']->addChild('Client list', array('route' => 'client_list'));
        $menu['Client']->addChild('Client create', array('route' => 'create_client'));
        $menu->addChild('Worker list', array('route' => 'client_list', 'routeParameters' => array('status', 1)));
        $menu->addChild('Terminal')
		->setUri('#');
        $menu['Terminal']->addChild('Terminal List', array('route' => 'terminal_list'));
        $menu['Terminal']->addChild('Terminal Create', array('route' => 'terminal_create'));
        $menu->addChild('Logout', array('route' => 'stop'));

        return $menu;
    }
}