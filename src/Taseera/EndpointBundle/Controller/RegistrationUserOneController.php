<?php

namespace Taseera\EndpointBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Taseera\UserBundle\Form\UserOneType;

/**
 * @RouteResource("registration_newUser", pluralize=false)
 */
class RegistrationUserOneController extends FOSRestController implements ClassResourceInterface
{

    /**
         * @Annotations\Post("/register-company")
     */
    public function registerAction(Request $request)
    {
        //$request = $this->getRequest();
        $discriminator = $this->container->get('pugx_user.manager.user_discriminator');
        $discriminator->setClass('Taseera\UserBundle\Entity\UserOne');
        $userManager = $this->container->get('pugx_user_manager');
        $user = $userManager->createUser();
        $dispatcher = $this->get('event_dispatcher');
        $formFactory = $this->get('fos_user.registration.form.factory');
        /*dump($formFactory);
        die();*/

        $user->setEnabled(true);
        $user->setUsername($request->get('username'));
        $user->setEmail($request->get('email'));
        $user->setPlainPassword($request->get('plainPassword'));
        //$user->setRoles(array('ROLE_API', 'ROLE_COMPANY'));
        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);
        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }
        $form = $formFactory->createForm(['csrf_protection'=>false]);
//        dump('********$form before setData*********');
//        dump($form);
        $form->setData($user);
        /*dump('********$form after setData*********');
        dump($form);
        die();*/
        $form->submit($request->request->all());
        if ( ! $form->isValid()) {
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);
            if (null !== $response = $event->getResponse()) {
                return $response;
            }
            return $form;
        }

        /*$event = new FormEvent($form, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);
        if ($event->getResponse()) {
            return $event->getResponse();
        }*/

        $userManager->updateUser($user);
        $response = new JsonResponse(
            [
                'msg' => $this->get('translator')->trans('registration.flash.user_created', [], 'FOSUserBundle'),
                'token' => $this->get('lexik_jwt_authentication.jwt_manager')->create($user), // creates JWT
                'id'=> $user->getId(),
                'username'=>$user->getUsername(),
                'email'=>$user->getEmail(),
                'image'=>$user->getImage(),
                'accepted'=>$user->getAccepted(),
                'phoneNumber'=>$user->getPhoneNumber(),
                'role'=>$user->getRoles(),
                'description'=>$user->isEnabled(),
                'categories'=>$user->getCategories()
            ],
            Response::HTTP_CREATED,
            [
                'Location' => $this->generateUrl(
                    'taseera_company_completeProfile',
                    [ 'user' => $user->getId() ],
                    UrlGeneratorInterface::ABSOLUTE_URL
                )
            ]
        );
        /*dump($user);
        die();*/
        $dispatcher->dispatch(
            FOSUserEvents::REGISTRATION_COMPLETED,
            new FilterUserResponseEvent($user, $request, $response)
        );
        return $response;
    }


}