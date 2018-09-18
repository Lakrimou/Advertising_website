<?php

namespace Taseera\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $companies = $em->getRepository('TaseeraUserBundle:UserOne')->findBy(
            array(),
            array('id'=>'desc'),
            5,
            0
        );
        $companyNumbers = $em->getRepository('TaseeraUserBundle:UserOne')->getCompaniesNumbers();
        $visitorNumbers = $em->getRepository('TaseeraBackendBundle:ViewsNumber')->getVisitorsNumbers();

        $users = $em->getRepository('TaseeraUserBundle:UserTwo')->findBy(
            array(),
            array('id'=>'desc'),
            5,
            0
        );
        $items = $em->getRepository('TaseeraBackendBundle:Item')->findBy(
            array(),
            array('id'=>'desc'),
            5,
            0
        );
        $itemNumbers = $em->getRepository('TaseeraBackendBundle:Item')->getItemNumbers();
        return $this->render('TaseeraBackendBundle:Default:index.html.twig', array(
            'companies'=>$companies,
            'companyNumbers'=>$companyNumbers,
            'itemNumbers'=>$itemNumbers,
            'users'=>$users,
            'items'=>$items,
            'visitorNumbers'=>$visitorNumbers));
    }
}
