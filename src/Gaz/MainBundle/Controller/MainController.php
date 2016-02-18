<?php

namespace Gaz\MainBundle\Controller;

use Gaz\MainBundle\Entity\Change;
use Gaz\MainBundle\Entity\Company;
use Gaz\MainBundle\Entity\LoginProvider;
use Gaz\MainBundle\Entity\ManyTransfer;
use Gaz\MainBundle\Form\ClientFormType;
use Gaz\MainBundle\Form\ClientType;
use Gaz\MainBundle\Form\CompanyType;
use Gaz\MainBundle\Form\FilterType;
use Gaz\MainBundle\Form\TerminalType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Config\Definition\Exception\ForbiddenOverwriteException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Process\PhpProcess;
use Symfony\Component\Process\Process;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class MainController extends Controller
{

    /**
     * This function has get all data for home page
     *
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $session = $this->get("session");
        $data = $session->get('workerDate');

        if($data != null && isset($data['code']) && $data['code'] != null)
        {
            $loginProvider = $em->getRepository('GazMainBundle:LoginProvider')->findByCode($data['code'], $data['date']);

            if(!$loginProvider)
            {
                $clientObj = $em->getRepository("GazMainBundle:Client")->findOneByCode($data['code']);
                //create login
                $loginProvider = new LoginProvider();
                $loginProvider->setWorker($clientObj);
                $loginProvider->setLoginTime($data['date']);
            }

            $loginProvider->setLogoutTime(new \DateTime('now'));

            $em->persist($loginProvider);
            $em->flush();

            $session->set('workerDate', null);
        }

        $form = $this->createForm(new ClientFormType());

        if ($request->isMethod('POST')) {
            // get request & check
            $form->handleRequest($request);

            if ($form->isValid()) {

                $userLog = $form->getData();
                $code = $userLog['cart'];

                $client = $em->getRepository("GazMainBundle:Client")->findClientGroupType($code);

                if($client && $client['groupe'] == Company::WORKER)
                {
                    $client['date'] = new \DateTime('now');
                    $session = $this->get("session");
                    $session->set('workerDate', $client);
                    $session->set('code', $client['groupe']);
                    $session->set('userCode', $code);
                    $this->container->get('session')->set('client', $client['groupe']);
                }

                if ($client['groupe'] == Company::WORKER) {
                    // get client
                    $clientObj = $em->getRepository("GazMainBundle:Client")->findOneByCode($code);

                    $change = $em->getRepository('GazMainBundle:Change')->findMax();

                    if(!$change)
                    {
                        $change = new Change();
                        $change->setOpen(new \DateTime('now'));
                        $change->setCash(0);
                        $em->persist($change);
                    }
                    //create login
                    $loginProvider = new LoginProvider();
                    $loginProvider->setWorker($clientObj);
                    $loginProvider->setLoginTime(new \DateTime('now'));
                    $loginProvider->setLogoutTime(new \DateTime('now'));
                    $loginProvider->setChange($change);

                    // persist login data
                    $em->persist($loginProvider);
                    $em->flush();

                    $session->set('workerDateObject', $clientObj);
                    $this->container->get('session')->set('type', 'worker');
                    return $this->redirect($this->generateUrl('login_cart'));
                } elseif ($client['groupe'] == Company::DIRECTOR) {


                   $this->loginUser($request);

                    if($this->getUser())
                    {
                        return $this->redirect($this->generateUrl('sonata_admin_dashboard'));
                    }

                } else {

                    $this->addFlash(
                        'error',
                        'Սխալ մուտքագրում'
                    );
                    return $this->redirect('/');
                }
            }
        }
        return array('form' => $form->createView());
    }

    private function loginUser(Request $request)
    {
        $user = $this->get('doctrine')->getRepository('GazMainBundle:User')->findOneByUsername('admin');
        // Here, "public" is the name of the firewall in your security.yml
        if (!$user) {
            throw new UsernameNotFoundException("User not found");
        } else {

            $token = new UsernamePasswordToken($user, $user->getPassword(), "public", $user->getRoles());
            $this->get("security.context")->setToken($token);

            // Fire the login event
            // Logging the user in above the way we do it doesn't do this automatically
            $event = new InteractiveLoginEvent($request, $token);
            $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
        }

    }

    /**
     * This function has get all data for home page
     *
     * @Route("/client", name="client")
     * @Template()
     */
    public function clientAction()
    {
        $em = $this->getDoctrine()->getManager();

        $data = $em->getRepository('GazMainBundle:Terminal')->findTerminals();

        if (is_null($data)) {
            throw new NotFoundHttpException('no data');
        }
        return array('data' => $data);
    }

    /**
     * This function has get all data for home page
     *
     * @Route("/login_cart", name="login_cart")
     * @Template()
     */
    public function loginCartAction()
    {
        $session = $this->get("session");
        $data = $session->get('workerDate');

        if(!$data)
        {
            return $this->redirect('/');
        }

        $em = $this->getDoctrine()->getManager();

        $data = $em->getRepository('GazMainBundle:Terminal')->findTerminals();

        if (!$data) {
            throw new NotFoundHttpException("Terminals not found");
        }

        return array('data' => $data);
    }

    /**
     * This function has get all data for home page
     *
     * @Route("/error/{massage}", name="error_message")
     * @Template()
     */
    public function errorAction($message)
    {
        return $message;
    }

    /**
     * @Route("/director/", name="director_check")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function directorAction()
    {
        $code = $this->get("session")->get('code');
        if ($code == Company::DIRECTOR) {
            return $this->render('GazMainBundle:Main:director.html.twig', array('code' => $code));

        } else {
            throw new ForbiddenOverwriteException('You are not Diretor');
        }

    }

    /**
     * @Route("/create/company", name="create_company")
     */
    public function createCompanyAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new CompanyType());

        if ($request->isMethod('POST')) {

            // get request & check
            $form->handleRequest($request);

            if ($form->isValid()) {

                $data = $form->getData();
                $em->persist($data);
                $em->flush();
            }
        }

        return $this->render('GazMainBundle:Main:createCompany.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/company/list/{status}", name="company_list")
     */
    public function listCompanyAction($status = null)
    {
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('GazMainBundle:Company')->findAllCompany($status);
        return $this->render('GazMainBundle:Main:listCompany.html.twig',
            array('companys' => $company)
        );
    }

    /**
     * @Route("/company/edit/{id}", name="company_edit")
     */
    public function editCompanyAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('GazMainBundle:Company')->find($id);
        $form = $this->createForm(new CompanyType(), $company);

        if ($request->isMethod('POST')) {

            // get request & check
            $form->handleRequest($request);

            if ($form->isValid()) {

                $data = $form->getData();
                $em->persist($data);
                $em->flush();
            }
        }

        return $this->render('GazMainBundle:Main:createCompany.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/create/client", name="create_client")
     */
    public function createClientAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new ClientType());

        if ($request->isMethod('POST')) {

            // get request & check
            $form->handleRequest($request);

            if ($form->isValid()) {

                $data = $form->getData();
                $em->persist($data);
                $em->flush();
            }
        }

        return $this->render('GazMainBundle:Main:createCompany.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/client/list/{status}", name="client_list")
     */
    public function listClientAction($status = null)
    {
        $em = $this->getDoctrine()->getManager();
        $clients = $em->getRepository('GazMainBundle:Client')->findClients($status);
        return $this->render('GazMainBundle:Main:listClient.html.twig',
            array('clients' => $clients)
        );
    }

    /**
     * @Route("/client/edit/{id}", name="client_edit")
     */
    public function editClientAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository('GazMainBundle:Client')->find($id);
        $form = $this->createForm(new ClientType(), $client);

        if ($request->isMethod('POST')) {

            // get request & check
            $form->handleRequest($request);

            if ($form->isValid()) {

                $data = $form->getData();
                $em->persist($data);
                $em->flush();
            }
        }

        return $this->render('GazMainBundle:Main:createCompany.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/stop", name="stop")
     */
    public function stopSessionAction()
    {
        $session = $this->get("session");
        $session->remove('code');
        return new RedirectResponse($this->generateUrl('homepage'));
//		return $this->redirect('homepage');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/list/filter", name="list_filter")
     */
    public function adminFilterAction(Request $request)
    {
        $data = null;
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new FilterType());
        $tables = null;

        if ($request->isMethod('POST')) {

            // get request & check
            $form->handleRequest($request);

            if ($form->isValid()) {

                $data = $form->getData();
                $tables = $em->getRepository('GazMainBundle:Finance')->findByFilter($data);

            }
        } else {
            $tables = $em->getRepository('GazMainBundle:Finance')->findByFilter($data);

        }
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($tables, $this->get('request')->query->get('page', 1) /* page number */, 10 /* limit per page */);

        return $this->render('GazMainBundle:Filter:filter.html.twig', array('pagination' => $pagination, 'form' => $form->createView()));
    }

    /**
     * This function use to create terminal
     * @Route("/terminal/create/{id}", name="terminal_create")
     */
    public function createTerminalAction(Request $request, $id = null)
    {
        $em = $this->getDoctrine()->getManager();

        if ($id != null) {
            $terminal = $em->getRepository('GazMainBundle:Terminal')->find($id);
        } else {
            $terminal = null;
        }
        $form = $this->createForm(new TerminalType(), $terminal);

        if ($request->isMethod('POST')) {

            // get request & check
            $form->handleRequest($request);

            if ($form->isValid()) {

                $data = $form->getData();
                $em->persist($data);
                $em->flush();
            }
        }

        return $this->render('GazMainBundle:Main:create_terminal.html.twig',
            array('form' => $form->createView())
        );

    }

    /**
     * This function use to terminal list
     * @Route("/terminal/list", name="terminal_list")
     */
    public function listTerminalAction()
    {
        $em = $this->getDoctrine()->getManager();

        $terminals = $em->getRepository('GazMainBundle:Terminal')->findAllForList();

        if (count($terminals) == 0) {
            throw new NotFoundHttpException('Terminals not found');
        }
        return $this->render('GazMainBundle:Main:list_terminal.html.twig',
            array('terminals' => $terminals)
        );

    }

    /**
     * This function use to terminal list
     * @Route("/test/repository", name="test_repository")
     */
    public function testRepositoryAction()
    {

        $descriptorspec = array(
            0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
        );

        $process = proc_open('lpr', $descriptorspec, $pipes);

        if (is_resource($process)) {
            // $pipes now looks like this:
            // 0 => writeable handle connected to child stdin
            // 1 => readable handle connected to child stdout
            // Any error output will be appended to /tmp/error-output.txt

            fwrite($pipes[0],
                'AAA ttt a  <p> ssss </p> <b> gjsghdfg</b> /n <p> jgdfgs <b>jgsdfj</b> </p> ');
            fclose($pipes[0]);
        }

        return 'ddd' ;
    }


}
