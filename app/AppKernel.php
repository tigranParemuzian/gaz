<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
	public function registerBundles()
	{
		$bundles = array(
			new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
			new Symfony\Bundle\SecurityBundle\SecurityBundle(),
			new Symfony\Bundle\TwigBundle\TwigBundle(),
			new Symfony\Bundle\MonologBundle\MonologBundle(),
			new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
			new Symfony\Bundle\AsseticBundle\AsseticBundle(),
			new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
			new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

			// custom bundles

			// fos bundles
			new FOS\UserBundle\FOSUserBundle(),
			new FOS\RestBundle\FOSRestBundle(),
//			new FOS\CommentBundle\FOSCommentBundle(),
			new Nelmio\ApiDocBundle\NelmioApiDocBundle(),

			//oauth bundle
//			new HWI\Bundle\OAuthBundle\HWIOAuthBundle(),

			// sonata bundles
			new Sonata\BlockBundle\SonataBlockBundle(),
			new Sonata\AdminBundle\SonataAdminBundle(),
			new Sonata\CoreBundle\SonataCoreBundle(),
			new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),
			new Sonata\IntlBundle\SonataIntlBundle(),
			new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
			new Knp\Bundle\MenuBundle\KnpMenuBundle(),
			new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),

			new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),

			// jms bundles
			new JMS\SerializerBundle\JMSSerializerBundle(),
			new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
			new JMS\AopBundle\JMSAopBundle(),
			new JMS\DiExtraBundle\JMSDiExtraBundle($this),

			new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
			new Gaz\MainBundle\GazMainBundle(),

			new Stfalcon\Bundle\TinymceBundle\StfalconTinymceBundle(),
			new A2lix\TranslationFormBundle\A2lixTranslationFormBundle(),

			new Liip\ImagineBundle\LiipImagineBundle(),
		);

		if (in_array($this->getEnvironment(), array('dev', 'test'))) {
			$bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
			$bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
			$bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
			$bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
		}

		return $bundles;
	}

	public function registerContainerConfiguration(LoaderInterface $loader)
	{
		$loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
	}
}
