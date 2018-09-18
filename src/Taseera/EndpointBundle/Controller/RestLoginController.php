<?php

namespace Taseera\EndpointBundle\Controller;

use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Symfony\Component\HttpFoundation\Request;

/**
 * @RouteResource("login", pluralize=false)
 */
class RestLoginController extends FOSRestController implements ClassResourceInterface
{
    public function postAction()
    {
        //$username = $request->request->get('username');
        // handled by Lexik JWT Bundle
        throw new \DomainException('You should never see this');
    }
}