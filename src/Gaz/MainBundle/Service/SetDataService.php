<?php

/**
 * Created by PhpStorm.
 * User: tigran
 * Date: 1/12/16
 * Time: 5:40 PM
 */
namespace Gaz\MainBundle\Service;


use Gaz\MainBundle\Entity\Finance;
use Symfony\Component\DependencyInjection\Container;

class SetDataService
{
    private $container;

    public function __construct(Container $container = null)
    {
        $this->container = $container;
    }

    public function setData($datas)
    {
        $message = array();

        $em = $this->container->get('doctrine')->getManager();

        foreach ($datas->result as $data)
        {
            $gaz = $em->getRepository("GazMainBundle:Finance")->findOneByGotcarq((int)$data->id);

            $station = $em->getRepository("GazMainBundle:Station")->findStation();

            if($gaz == null)
            {
                if((int)substr($data->summa, -2) != 0)
                {
                    if(substr($data->summa, -2)<=25)
                    {
                        $cost = $data->summa - substr($data->summa, -2);
                    }
                    elseif(substr($data->summa, -2)>25 && substr($data->summa, -2) <=50)
                    {
                        $cost = $data->summa - substr($data->summa, -2) + 50;
                    }
                    elseif(substr($data->summa, -2)>50 && substr($data->summa, -2) <=75) {

                        $cost = $data->summa - substr($data->summa, -2) + 50;
                    }
                    elseif(substr($data->summa, -2)>75 && substr($data->summa, -2) <=100) {

                        $cost = $data->summa - substr($data->summa, -2) + 100;
                    }
                    else
                    {
                        $cost = $data->summa;
                    }
                }
                else
                {
                    $cost = $data->summa ;
                }

                    if($cost >0)
                    {
                        $residue = $cost - $data->summa;

                        $terminal = $em->getRepository('GazMainBundle:Terminal')->findOneByNumber((int)$data->shlang_id);

                        $finance = new Finance();
                        $finance->setTerminal($terminal);
                        $finance->setBalance(0);
                        $finance->setCreated(new \DateTime('now'));
                        $finance->setPrice($cost);
                        $finance->setDeposit(0);
                        $finance->setResidue($residue);
                        $finance->setGotcarq($data->id);
                        $finance->setStation($station);

                        $validation = $this->container->get('validator');

                        $errors = $validation->validate($finance);

                        if(count($errors)>0)
                        {
                            $errorString = (string)$errors;
                            $message[$data->id]['error'] = $errorString;
                            $logger = $this->container->get('monolog.logger.urldataerror');
                            $logger->addInfo($errorString);

                        }
                        else
                        {
                            $em->persist($finance);
                            $message[$data->id]['success'] = $finance->getId();
                            $logger = $this->container->get('monolog.logger.urldataok');
                            $logger->addInfo($message[$data->id]['success']);

                        }
                    }

            }
        }

        $em->flush();
        $em->clear();

        $em->getConnection()->getConfiguration()->setSQLLogger(null);

        return $message;
    }

}