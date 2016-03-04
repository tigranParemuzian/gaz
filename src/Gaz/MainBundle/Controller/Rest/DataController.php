<?php
/**
 * Created by PhpStorm.
 * User: tigran
 * Date: 7/25/15
 * Time: 5:54 PM
 */
namespace Gaz\MainBundle\Controller\Rest;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations as Rest;
use Gaz\MainBundle\Entity\Change;
use Gaz\MainBundle\Entity\Client;
use Gaz\MainBundle\Entity\Company;
use Gaz\MainBundle\Entity\Finance;
use Gaz\MainBundle\Entity\ManyTransfer;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Config\Definition\Exception\ForbiddenOverwriteException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints\DateTime;


/**
 * Class InfoController
 *
 * @package Gaz\MainBundle\Controller
 *
 * @RouteResource("Gaz")
 * @Rest\Prefix("/api")
 */
class DataController extends FOSRestController
{
    const ENTITY = 'GazMainBundle:Gaz';

    /**
     * *
     * @ApiDoc(
     *  resource=true,
     *  section="Gaz",
     *  description="This function is used to join or reject Moderator from User.",
     *  statusCodes={
     *         202="Returned when created",
     *         404="Return when user not found", }
     * )
     *
     * This function is duplicate rejected info
     * @Rest\View()
     *
     */
    public function getDataClientAction($code, $terminalId)
    {

        $em = $this->getDoctrine()->getManager();

        $clientData = $em->getRepository("GazMainBundle:Client")->findClientDataByCode($code);

        if ($clientData['types'] == Company::COMPANY) {
            $type = 'company';
        } elseif ($clientData['types'] == Company::WORKER) {
            $type = 'worker';
        } elseif ($clientData['types'] == Company::DIRECTOR) {
            $type = 'director';
        } else {
            $type = 'citizen';
        }
        return array('tetminal' => $terminalId, 'type' => $type, 'clientData' => $clientData, 'code' => $code);
    }

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Gaz",
     *  description="This function is used to join or reject Moderator from User.",
     *  statusCodes={
     *         202="Returned when created",
     *         404="Return when user not found", }
     * )
     *
     *
     * @Rest\View()
     * @param Request $request
     * @return array
     */
    public function postInputAction(Request $request)
    {
        // get entity manager
        $em = $this->getDoctrine()->getManager();
        // get validator
        $validator = $this->container->get('validator');
        // get content data
        $obj = json_decode($request->getContent());
        // create default messages
        $message = 'success';
        $msg = 'ok';
        $deposit = 0;

        $worker = $this->get("session")->get('workerDateObject');

        $gotcarq = $obj->gotcarq;
        $terminalId = $obj->terminalId;
        $sum =$obj->summa;
        $client = (string)$obj->client;
        // check gotcarq in object
        if ($gotcarq != null && $terminalId != null &&
            $sum != null && $client != null && $worker != null) {

            // get finance if exist in database by gotcarq code (is unique)
            $gaz = $em->getRepository("GazMainBundle:Finance")->findOneByGotcarq((int)$gotcarq);

            if(!$gaz)
            {
                $msg = 'Գործարքը գոյություն չունի ';
                return array($message => 'warning', 'msg'=>$msg);
            }

        } else {

            $msg = 'Ծրագրային սխալ։';
            return array($message => 'warning', 'msg'=>$msg);
        }

        // search client in database by code
        $clientBuy = $em->getRepository("GazMainBundle:Client")->findOneByCode($client);

        if(!$clientBuy)
        {
            $message = 'warning';
            $msg = 'Քարտատերը գոյություն չունի։';
            return array('message'=>$message, 'msg'=>$msg);
        }

        $worker = $em->getRepository("GazMainBundle:Client")->findOneByCode((string)$worker->getCode());

        if(!$worker) {
            $message = 'warning';
            $msg = 'Համակարգում աշխատողը բացակայում է։';
            return array('message'=>$message, 'msg'=>$msg);
        }

        if($worker->getCode() != $clientBuy->getCode())
        {
            $paymentType = $clientBuy->getPaymentTypes();

            $oldDeposit = $clientBuy->getDepositLimit();

            switch($paymentType) {

                case ($paymentType = Client::CASH):

                    $deposit = (int)($clientBuy->getPercent() * $sum / 100);
                    $clientBuy->setCashInfo($clientBuy->getCashInfo() + ($deposit));
                    $gaz->setDeposit($deposit);

                    break;
                case ($paymentType = Client::FREE):

                    break;
                case ($paymentType = Client::TRANSFER):

                    $clientBuy->setCashInfo($clientBuy->getCashInfo() + ($deposit));
                    $gaz->setDeposit($deposit);

                    break;
            }
        }

        $clientName = $clientBuy->getName();

        $clientState = $clientBuy->getCompany()->getGroupType();

        $worker->setCashInfo($worker->getCashInfo() + $gaz->getPrice());

        $em->persist($clientBuy);
        $em->persist($worker);

        $gaz->setClientBuy($clientBuy);
        $gaz->setClientSale($worker);
        $gaz->setCreated(new \DateTime('now'));
        $gaz->setFinanceType(true);

        $errors = $validator->validate($gaz);

        if (count($errors) > 0 || $message === 'warning') {
            $message = 'warning';
            $errorsString = (string)$errors;

            $msg = "Finance , $errorsString , $msg!";
            return array('terminalId' => $terminalId, 'message' => $message, 'msg' => $msg);

        }

        $em->persist($gaz);
        $em->flush();

        return array('id' => $gaz->getId(), 'finance' => $gaz->getGotcarq(), 'deposit' => $deposit,
            'terminalId' => $terminalId, 'message' => $message, 'cache' => $gaz->getPrice(),
            'clientName' => $clientName, 'clientState' => $clientState);
    }

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Gaz",
     *  description="This function is used to join or reject Moderator from User.",
     *  statusCodes={
     *         202="Returned when created",
     *         404="Return when user not found", }
     * )
     *
     * @Rest\View()
     * @param $code
     * @return string
     */
    public function getFinanceAction($code, $date)
    {

        $em = $this->getDoctrine()->getManager();


        $fianace = $em->getRepository('GazMainBundle:Finance')->findFinanceByTerminal($code);
        if ($fianace['created']->date > $date) {
            $message = 'sucssess';
        } else {
            $message = 'waitind';
        }
        return $message;
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  section="Gaz",
     *  description="This function is used to join or reject Moderator from User.",
     *  statusCodes={
     *         202="Returned when created",
     *         404="Return when user not found", }
     * )
     *
     * @Rest\View()
     * @return mixed
     */
    public function getLastFinanceAction()
    {

        $em = $this->getDoctrine()->getManager();

        $finance = $em->getRepository('GazMainBundle:Terminal')->findDataLast();

        return $finance;

    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  section="Gaz",
     *  description="This function is used to join or reject Moderator from User.",
     *  statusCodes={
     *         202="Returned when created",
     *         404="Return when user not found", }
     * )
     *
     * @Rest\View()
     * @param $terminal
     * @param $code
     * @return string
     */
    public function getDeleteAction($terminal, $code)
    {
        $em = $this->getDoctrine()->getManager();
        $validator = $this->container->get('validator');

        $finance = $em->getRepository('GazMainBundle:Finance')->findLastForRemove($terminal, $code);

        $msg = "Գործարգ $terminal տերմինալի վրա չգտնվեց";

        if (count($finance) > 0) {

            $finance->setFinanceType(false);
            $finance->setDeposit(null);

            $errors = $validator->validate($finance);

            if (count($errors) > 0) {
                $errorsString = (string)$errors;
                $msg = "Գործարգը չի կարող ջնջվել , $errorsString !";
                return $msg;

            } else {

                $em->persist($finance);
                $em->flush();

                $msg = "Գործարգը տերմինալ $terminal ֊ի վրա ջնջված է ";
            }
        }

        return $msg;

    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  section="Gaz",
     *  description="This function is used to join or reject Moderator from User.",
     *  statusCodes={
     *         202="Returned when created",
     *         404="Return when user not found", }
     * )
     *
     * @Rest\View()
     * @param $terminalId
     * @return array|string
     */
    public function getTerminalAction($terminalId)
    {
        $em = $this->getDoctrine()->getManager();

        $finance = $em->getRepository('GazMainBundle:Terminal')->findDataLastByTermianl($terminalId);

        if (!$finance) {
            return 'worning';
        } else {
            return $finance;
        }


    }

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Gaz",
     *  description="This function is used to join or reject Moderator from User.",
     *  statusCodes={
     *         202="Returned when created",
     *         404="Return when user not found", }
     * )
     *
     * @Rest\View()
     * @param $terminalId
     * @return array|null
     */
    public function getCountByTerminalAction($terminalId)
    {
        $em = $this->getDoctrine()->getManager();
        $count = $em->getRepository('GazMainBundle:Finance')->findCount($terminalId);

        if(!$count)
        {
            return null;
        }
        return $count;
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  section="Gaz",
     *  description="This function is used to join or reject Moderator from User.",
     *  statusCodes={
     *         202="Returned when created",
     *         404="Return when user not found", }
     * )
     *
     * @Rest\View()
     * @return array
     */
    public function getCountAction()
    {
        $em = $this->getDoctrine()->getManager();

        $count = $em->getRepository('GazMainBundle:Terminal')->findCount();

        return $count;
    }

    /**
     * This function get nav barr data
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Gaz",
     *  description="This function is used to join or reject Moderator from User.",
     *  statusCodes={
     *         202="Returned when created",
     *         404="Return when user not found", }
     * )
     *
     * @Rest\View()
     */
    public function getNavDataAction()
    {
        $em = $this->getDoctrine()->getManager();

        $worker = $this->container->get('session')->get('workerDate');

        $change = $em->getRepository('GazMainBundle:Change')->findMax();

        $date = $change->getOpen();
        $count = $em->getRepository('GazMainBundle:Finance')->findNavData($date, $worker['code']);


        return $count;
    }

    /**
     * This function get nav barr data
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Gaz",
     *  description="This function is used to join or reject Moderator from User.",
     *  statusCodes={
     *         202="Returned when created",
     *         404="Return when user not found", }
     * )
     *
     * @Rest\View()
     */
    public function postChangeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $message = null;

        $obj = json_decode($request->getContent());

        $session = $this->container->get('session');
        $worker = $session->get('userCode');

        if((int)$obj->oldWorker == $worker)
        {
            $client = $em->getRepository("GazMainBundle:Client")->findClientGroupType($obj->newWorker);
            $client['date'] = new \DateTime('now');
            $session = $this->get("session");
            $session->set('workerDate', $client);
            $session->set('code', $client['groupe']);
            $session->set('userCode', $obj->newWorker);
            $this->container->get('session')->set('client', $client['groupe']);

            if ($client['groupe'] == Company::WORKER) {
                $this->container->get('session')->set('type', 'worker');
                $message = 'success';
                return $this->redirect($this->generateUrl('login_cart'));
            } elseif ($client['groupe'] == Company::DIRECTOR) {
                $this->container->get('session')->set('type', 'director');
                $message = 'success';
                return $this->redirect($this->generateUrl('director_check'));
            } else {
                $message = 'Worker can`t login, new client by cart code not worker .';
            }
        }
        else {
            $message = 'Worker can`t login, old worker cod is invalid';
        }


        return $message;
    }

    /**
     * This function get nav barr data
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Gaz",
     *  description="This function is used to join or reject Moderator from User.",
     *  statusCodes={
     *         202="Returned when created",
     *         404="Return when user not found", }
     * )
     *
     * @Rest\View(serializerGroups={"client"})
     * @param $code
     * @return client
     */
    public function getInfoByCartAction($code)
    {
        $em = $this->getDoctrine()->getManager();

        $client = $em->getRepository('GazMainBundle:Client')->findOneByCode($code);

        if(!$client)
        {
            return new JsonResponse("Մուտքագրված քարտատերը գոյություն չունի", Response::HTTP_NOT_FOUND);
        }

        return $client;

    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  section="Gaz",
     *  description="This function is used to join or reject Moderator from User.",
     *  statusCodes={
     *         202="Returned when created",
     *         404="Return when user not found", }
     * )
     *
     *
     * @Rest\View(serializerGroups={"terminal"})
     */
    public function getTerminalCountsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $terminals = $em->getRepository('GazMainBundle:Terminal')->findNumbers();

        return $terminals;
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  section="Gaz",
     *  description="This function is used to join or reject Moderator from User.",
     *  statusCodes={
     *         202="Returned when created",
     *         404="Return when user not found", }
     * )
     *
     *
     * @Rest\View(serializerGroups={"client"})
     */
    public function postManyTransferAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

//        // get date form request
//        $worker=$request->get('worker');
//        $cash=$request->get('cash');
//        $director=$request->get('director');

        // get content data
        $obj = json_decode($request->getContent());

        // get date form request
        $worker = $obj->worker;
        $cash = $obj->cash;
        $director = $obj->director ? $obj->director : null;
        $message = $obj->message ? $obj->message : null;

        if($worker != null && $cash != null && ($director != null || $message != null))
        {
            // if exist get transfer
            $maxManyTransfer = $em->getRepository('GazMainBundle:ManyTransfer')->findBySenderCode($worker);
            if($director == null)
            {
                $director = $worker;
            }
            $data = array();
            // if transfer not exist
            if(!$maxManyTransfer) {
                // get data for create new transfer

                $manyTransferData = $em->getRepository('GazMainBundle:Client')->findManyTransfer($worker, $director);
                // calculate data and create data for transfer
                foreach($manyTransferData as $transferData)
                {
                    // check sender
                    if(isset($transferData['sender']) && ($transferData['sender'] instanceof Client))
                    {
                        $data['sender'] = $transferData['sender'];
                        $senderName = $transferData['sender']->getName();
                        // check many whose can transfer
                        if($cash <= $transferData['sender']->getCashInfo() )
                        {
                            $data['cash'] = $cash;

                            $cashBalance = $transferData['sender']->getCashInfo() - $cash;
                            // set new data for balance
                            $transferData['sender']->setCashInfo($cashBalance);
                            $transferData['sender']->setCreated(new \DateTime('now'));

                            $em->persist($transferData['sender']);

                        }
                        else {

                            return array('senderName'=>$senderName, 'cash'=>$cash, 'cashBalance'=>$transferData['sender']->getCashInfo(), 'message'=>'worning');
                        }
                    }
                    elseif(isset($transferData['recipient']) && ($transferData['recipient'] instanceof Client) && ($transferData['recipient'] != $transferData['sender']) && $message === null)
                    {
                        $data['recipient'] = $transferData['recipient'];
                        // send many
                        $data['recipient']->setCashInfo($data['recipient']->getCashInfo() + $cash);
                        $em->persist($data['recipient']);
                        $recipientName = $transferData['recipient']->getName();
                    }
                }

            }
            else {

                $manyTransferData = $em->getRepository('GazMainBundle:Client')->findManyTransferData($worker, $director);

                foreach($manyTransferData as $transferData)
                {
                    if(isset($transferData['sender']) && ($transferData['sender'] instanceof Client))
                    {
                        $data['sender'] = $transferData['sender'];
                        $senderName = $transferData['sender']->getName();

                        if(strtotime($transferData['sender']->getCreated()->format('Y-m-d h:i')) >= $maxManyTransfer['created']->format('Y-m-d h:i') &&
                            $cash <= $transferData['sender']->getCashInfo() )
                        {
                            $data['cash'] = $cash;

                            $cashBalance = $transferData['sender']->getCashInfo() - $cash;

                            $transferData['sender']->setCashInfo($cashBalance);
                            $transferData['sender']->setCreated(new \DateTime('now'));

                            $em->persist($transferData['sender']);

                        }
                        else {

                            return array('senderName'=>$senderName, 'cash'=>$cash, 'cashBalance'=>$transferData['sender']->getCashInfo(), 'message'=>'worning');
                        }
                    }
                    elseif(isset($transferData['recipient']) && ($transferData['recipient'] instanceof Client) && ($transferData['recipient'] != $transferData['sender']) && $message === null)
                    {
                        $data['recipient'] = $transferData['recipient'];
                        // send many
                        $data['recipient']->setCashInfo($data['recipient']->getCashInfo() + $cash);
                        $em->persist($data['recipient']);
                        $recipientName = $transferData['recipient']->getName();
                    }
                }
            }

            // create Many Transfer
            if(count($data) == 3)
            {

                $manyTransfer = new ManyTransfer();

                $manyTransfer->setCash($data['cash']);
                $manyTransfer->setCreated(new  \DateTime('now'));
                $manyTransfer->setSender($data['sender']);
                $manyTransfer->setRecipient($data['recipient']);
                $message ? $manyTransfer->setMessage($message) : $manyTransfer->setMessage(' ');
                $em->persist($manyTransfer);
                $em->flush();
            }
        }

        return array( 'recipientName'=>$recipientName, 'senderName'=>$senderName, 'cash'=>$cash, 'cashBalance'=>$cashBalance, 'message'=>'success', 'transferInfo'=>$message);
    }

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Gaz",
     *  description="This function is used to join or reject Moderator from User.",
     *  statusCodes={
     *         202="Returned when created",
     *         404="Return when user not found", }
     * )
     *
     *
     * @Rest\View()
     *
     * @param $code
     * @return array
     */
    public function getEndedChangeAction($code)
    {
        $em = $this->getDoctrine()->getManager();
        $validator = $this->container->get('validator');
        $many = null;

        if($code != null)
        {

            $change = $em->getRepository('GazMainBundle:Change')->findMax();

            $now = new \DateTime('now');

            if($change)
            {
                $begin = $change->getOpen();

                $cash = $em->getRepository('GazMainBundle:Finance')->findCash($begin, $now);
                $percent = $em->getRepository('GazMainBundle:Settings')->findAll();


                $many = $cash['cash'];

                $change->setCash($many);
                $change->setEnded($now);

                if($percent)
                {
                    $paymentPercent = $many * $percent[0]->getPaymentPercent() / 100 ;
                    $change->setPaymentPercent($paymentPercent);
                }
                else {
                    $paymentPercent = null;
                }


                $error = $validator->validate($change);

                if(count($error)>0)
                {
                    return new JsonResponse('aaaaaa');
                }
                else
                {
                    $em->persist($change);
                }

            }

            $newChange = new Change();
            $newChange->setOpen($now);
            $newChange->setCash(0);
            $newChange->setPaymentPercent(0.01);

            $error = $validator->validate($change);

            if(count($error)>0)
            {
                return new JsonResponse('bbbb');
            }
            else
            {
                $em->persist($newChange);
            }

            $em->flush();
        }

        return array('message'=>'success', 'data' =>array('cash'=>$many, 'paymentPercent'=>$paymentPercent));
    }

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Gaz",
     *  description="This function is used to join or reject Moderator from User.",
     *  statusCodes={
     *         202="Returned when created",
     *         404="Return when user not found", }
     * )
     *
     *
     * @Rest\View()
     */
    public function getUrlsAction()
    {
        $urlLocal = $this->container->getParameter('url_local');
        $urlExternal = $this->container->getParameter('url_external');

        $checkDataLocal = $this->getContent($urlLocal);

        if($checkDataLocal != null)
        {
            $url = $urlLocal;
        }
        else {

            $url = $urlExternal;
        }

        return urlencode($url);
    }

    /**
     * This function is used to get content from $link
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

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Gaz",
     *  description="This function is used to get last transfer info.",
     *  statusCodes={
     *         202="Returned when created",
     *         404="Return when user not found", }
     * )
     *
     *
     * @Rest\View(serializerGroups={"many_transfer"})
     */
    public function getLastChangeAction()
    {
       $em = $this->getDoctrine()->getManager();

        $data = $em->getRepository('GazMainBundle:Change')->findMaxResult();

        if(!$data)
        {
            return new JsonResponse("No data", Response::HTTP_NOT_FOUND);
        }

        return $data;
    }

    /**
     * @param $code
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Gaz",
     *  description="This function is used to get many by clint code.",
     *  statusCodes={
     *         202="Returned when created",
     *         404="Return when user not found", }
     * )
     *
     *
     * @Rest\View()
     */
    public function getManyAction($code)
    {
        $many = $this->getDoctrine()->getManager()->getRepository('GazMainBundle:Client')->findOneByCode($code)->getCashInfo();

        return $many;
    }
}