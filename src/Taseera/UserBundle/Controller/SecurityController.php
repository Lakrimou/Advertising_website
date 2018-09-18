<?php
namespace Taseera\UserBundle\Controller;
use FOS\UserBundle\Controller\SecurityController as BaseeController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
/**
 * {@inheritDoc}
 */
class SecurityController extends BaseeController
{
    public function renderLogin(array $data)
    {
        $requestAttributes = $this->container->get('request_stack')->getCurrentRequest()->attributes;
        if ($requestAttributes->get('_route') == 'admin_login') {
            $template = sprintf('TaseeraUserBundle:Security:login.html.twig');
        } elseif($requestAttributes->get('_route') == 'company_login') {
            $template = sprintf('TaseeraUserBundle:Security:login_company.html.twig');
        }else {
            $template = sprintf('TaseeraUserBundle:Security:login_user.html.twig');
        }
        return $this->container->get('templating')->renderResponse($template, $data);
    }
}