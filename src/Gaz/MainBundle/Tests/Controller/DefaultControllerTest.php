<?php

namespace Mankapartez\MainBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class DefaultControllerTest
 * @package Mankapartez\MainBundle\Tests\Controller
 */
class DefaultControllerTest extends WebTestCase
{
    /**
     *  Index Test
     */
    public function testIndex()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }


    /**
     *  Messages Test
     */
    public function testMessages()
    {
        $client = static::createClient();

        $client->request('GET', '/messages/');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }


    /**
     *  Kindergarten test
     */
    public function testKindergarten()
    {
        $client = static::createClient();

        $client->request('GET', '/kindergarten/');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }


    /**
     *  Kindergarten Payments Test
     */
    public function testKindergartenPayments()
    {
        $client = static::createClient();

        $em = $client->getContainer()->get("doctrine")->getManager();
        $entity = $em->getRepository("MankapartezMainBundle:Payment")->findAll();
        if (!$entity[0]) {
            $this->assertTrue(false);
        } else {
            $client->request('GET', '/' . $entity[0]->getId() . '/payments/');

            $this->assertTrue($client->getResponse()->isSuccessful());
        };
    }


    /**
     *  Payments Test
     */
    public function testPayments()
    {
        $client = static::createClient();

        $client->request('GET', '/payments/');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }


    /**
     *  Kinder Garten More Test
     */
    public function testKindergartenMore()
    {
        $client = static::createClient();

        $em = $client->getContainer()->get("doctrine")->getManager();
        $entity = $em->getRepository("MankapartezMainBundle:Kindergarden")->findAll();


        if (!$entity[0]) {
            $this->assertTrue(false);
        } else {

            $client->request('GET', '/kindergarten/' . $entity[0]->getId() . "/");

            $this->assertTrue($client->getResponse()->isSuccessful());
        };
    }

    /**
     *  Kindergarten Map Test
     */
    public function testKindergartenMap()
    {
        $client = static::createClient();

        $client->request('GET', '/map/');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }


    /**
     *  News Test
     */
    public function testNews()
    {
        $client = static::createClient();

        $client->request('GET', '/news/');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     *   More News Test
     */
    public function testNewsMore()
    {
        $client = static::createClient();

        $em = $client->getContainer()->get("doctrine")->getManager();
        $entity = $em->getRepository("MankapartezMainBundle:News")->findAll();
        if (!$entity[0]) {
            $this->assertTrue(false);
        } else {


            $client->request('GET', '/news/' . $entity[0]->getId() . "/");

            $this->assertTrue($client->getResponse()->isSuccessful());
        };
    }

    /**
     *  Contact Test
     */
    public function testContact()
    {
        $client = static::createClient();

        $client->request('GET', '/contact/');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }


    /**
     *  Sent test
     */
    public function testSent()
    {
        $client = static::createClient();

        $client->request('GET', '/am/contact/sent/');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }


    /**
     *  NotSend Test
     */
    public function testNotSent()
    {
        $client = static::createClient();

        $client->request('GET', '/contact/not_sent/');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }


    /**
     * Problem test
     */
    public function testProblem()
    {
        $client = static::createClient();

        $client->request('GET', '/problem/');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * ProblemSolved Test
     */
    public function testProblemsSolved()
    {
        $client = static::createClient();

        $client->request('GET', '/problems_solved/');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }


    /**
     *  Garden Problem Test
     */
    public function testProblemGarden()
    {
        $client = static::createClient();

        $em = $client->getContainer()->get("doctrine")->getManager();
        $entity = $em->getRepository("MankapartezMainBundle:Problem")->findAll();
        if (!$entity[0]) {
            $this->assertTrue(false);
        } else {

            $client->request('GET', '/problems/' . $entity[0]->getId() . "/");

            $this->assertTrue($client->getResponse()->isSuccessful());
        };
    }


    /**
     *  ProblemShow Test
     */
    public function testProblemShow()
    {
        $client = static::createClient();

        $em = $client->getContainer()->get("doctrine")->getManager();
        $entity = $em->getRepository("MankapartezMainBundle:Problem")->findAll();
        if (!$entity[0]) {
            $this->assertTrue(false);
        } else {

            $client->request('GET', '/problem/' . $entity[0]->getId() . "/");

            $this->assertTrue($client->getResponse()->isSuccessful());
        };
    }

    /**
     *  This Function is Not Implemented in Controller.
     */
    /*
    public function testRate()
    {
        $client = static::createClient();

        $client->request('GET', '/rate/');

        $this->assertTrue($client->getResponse()->isSuccessful()); };
    }

    */


    /**
     * Donation Test
     */
    public function testDonate()
    {
        $client = static::createClient();

        $client->request('GET', '/donation/');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }


    /**
     *  Top Statistics Test
     */

    public function testTopStatistics()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }


    /**
     *  Search Test
     */
    public function testSearch()
    {
        $client = static::createClient();

        $client->request('GET', '/search/');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     *  Full Gallery Test
     */
    public function testGalleryFull()
    {
        $client = static::createClient();
        $em = $client->getContainer()->get("doctrine")->getManager();
        $entity = $em->getRepository("ApplicationSonataMediaBundle:Gallery")->findAll();
        if (!$entity[0]) {
            $this->assertTrue(false);
        } else {

            $client->request('GET', '/' . $entity[0]->getId() . '/gallery_full/');

            $this->assertTrue($client->getResponse()->isSuccessful());
        };
    }


    /**
     *  Gallery Test
     */
    public function testGallery()
    {
        $client = static::createClient();

        $em = $client->getContainer()->get("doctrine")->getManager();
        $entity = $em->getRepository("ApplicationSonataMediaBundle:Gallery")->findAll();
        if (!$entity[0]) {
            $this->assertTrue(false);
        } else {

            $client->request('GET', '/' . $entity[0]->getId() . '/gallery/');

            $this->assertTrue($client->getResponse()->isSuccessful());
        };
    }


}
