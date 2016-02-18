<?php

namespace Gaz\MainBundle\Command;

use Doctrine\ORM\Query\ResultSetMapping;
use Gaz\MainBundle\Entity\Finance;
use Symfony\Bundle\FrameworkBundle\Command\CacheClearCommand;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Class SetDataCommand
 * @package AppBundle\Command
 */
class SetDataCommand extends ContainerAwareCommand
{

	/**
	 * This function is used to get content from $link
	 *
	 * @param $link
	 * @param null $context
	 * @return mixed|null|string
	 */
	private function getContent($link, $context = null)
	{
		// reads a file into a string.
		$content = @file_get_contents($link, false, $context);

		if ($content) {
			// content json decode
			$content = json_decode($content);

			if (isset($content->status) && $content->status != 404) {
				$content = null;
			}
		}
		else {
			$content = null;
		}

		return $content;
	}

	protected function configure()
	{
		$this
			->setName('set:input:data')
			->setDescription('Start set input data');
	}

	/**
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln("<info>Starting add Finance from url</info>");

		//ini_set('memory_limit', '2048M');
		//ini_set('max_execution_time', '42000');

		$urlLocal = $this->getContainer()->getParameter('url_local');
		$urlExternal = $this->getContainer()->getParameter('url_external');

		$checkDataLocal = $this->getContent($urlLocal);

		if($checkDataLocal != null)
		{
			$url = $urlLocal;
		}
		else {

			$url = $urlExternal;
		}

		$i = true;

		do
		{
			$datas = $this->getContent($url);

			sleep(2);

			if(count($datas) > 0)
			{
				$this->getContainer()->get('set_data_from_url')->setData($datas);
				gc_collect_cycles();
            }
            else
            {
				$logger = $this->getContainer()->get('monolog.logger.urldataerror');
				$logger->addInfo('missing data');
            }

		} while ($i);


		$output->writeln("<info>End create data from url</info>");
	}
}