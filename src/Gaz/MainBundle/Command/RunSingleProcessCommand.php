<?php

namespace Gaz\MainBundle\Command;

use Doctrine\ORM\Query\ResultSetMapping;
use Gaz\MainBundle\Entity\Finance;
use Symfony\Bundle\FrameworkBundle\Command\CacheClearCommand;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Process\PhpProcess;

/**
 * Class SetDataCommand
 * @package AppBundle\Command
 */
class RunSingleProcessCommand extends ContainerAwareCommand
{
	protected function configure()
	{
		$this
			->setName('set:single:input:data')
			->setDescription('Start set single input data')
			->addArgument(
				'data',
				InputArgument::REQUIRED,
				'array'
			);
	}

	/**
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$datas = $input->getArgument('data');

		$logger = $this->getContainer()->get('monolog.logger.urldataok');
		$logger->addInfo($datas);
		$datas = json_decode($datas);

		if(is_array($datas))
		{
			$logger = $this->getContainer()->get('monolog.logger.urldataok');
			$logger->addInfo('aassasdsddffg g g g g g');
			$this->getContainer()->get('set_data_from_url')->setData($datas);
		}


	}
}