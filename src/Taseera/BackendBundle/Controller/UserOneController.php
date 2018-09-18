<?php

namespace Taseera\BackendBundle\Controller;

use Taseera\UserBundle\Entity\User;
use Taseera\UserBundle\Entity\UserOne;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;  
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEven;
use FOS\UserBundle\Event\GetResponseUserEvent;

/**
 * Userone controller.
 *
 */
class UserOneController extends Controller
{
    /**
     * Lists all userOne entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $utilisateurs = array();
        $tab = array();
        $i = 0;
        $userOnes = $em->getRepository('TaseeraUserBundle:UserOne')->findAll();
        $users = $em->getRepository('TaseeraUserBundle:User')->findAll();
        foreach ($users as $user)
        {
            //var_dump($user);
            foreach ($userOnes as $userOne){
                //var_dump($userOne);
                if($userOne->getId()==$user->getId())
                {
                    $utilisateurs[$i]['id'] = $user->getId();
                    $utilisateurs[$i]['sUsername'] = $user->getUsername();
                    $utilisateurs[$i]['sEmail'] = $user->getEmail();
                    $utilisateurs[$i]['accepted'] = $user->getAccepted();
                    $utilisateurs[$i]['image'] = $user->getImage();
                    $i++;
                }
            }
            $tab['data'] = $utilisateurs;
        }
        return $this->render('TaseeraBackendBundle:userone:index.html.twig', array(
            'userOnes' => $utilisateurs,
        ));
    }

    /**
     * Creates a new userOne entity.
     *
     */
  public function newAction(Request $request)
    {
        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->createUser();
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                $userManager->updateUser($user);

                if (null === $response = $event->getResponse()) {
                    $url = $this->generateUrl('fos_user_registration_confirmed');
                    $response = new RedirectResponse($url);
                }

                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                return $response;
            }

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);

            if (null !== $response = $event->getResponse()) {
                return $response;
            }
        }

        return $this->render('TaseeraBackendBundle:userone:new.html.twig', array(
            'form' => $form->createView(),
        ));

        /*return $this->render('TaseeraBackendBundle:userone:new.html.twig');*/

    }

    /**
     * Finds and displays a userOne entity.
     *
     */
    public function showAction(UserOne $userOne)
    {
        $deleteForm = $this->createDeleteForm($userOne);

        return $this->render('TaseeraBackendBundle:userone:show.html.twig', array(
            'userOne' => $userOne,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing userOne entity.
     *
     */
    public function editAction(Request $request, UserOne $userOne)
    {
        $deleteForm = $this->createDeleteForm($userOne);
        $editForm = $this->createForm('Taseera\UserBundle\Form\UserOneType', $userOne);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('userone_edit', array('id' => $userOne->getId()));
        }

        return $this->render('TaseeraBackendBundle:userone:edit.html.twig', array(
            'userOne' => $userOne,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a userOne entity.
     *
     */
    public function deleteAction(Request $request, UserOne $userOne)
    {
        $form = $this->createDeleteForm($userOne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userOne);
            $em->flush();
        }

        return $this->redirectToRoute('userone_index');
    }

    /**
     * Creates a form to delete a userOne entity.
     *
     * @param UserOne $userOne The userOne entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserOne $userOne)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('userone_delete', array('id' => $userOne->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function deleteCompanyAction(Request $request, User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('userone_index');
    }

    public function confirmRefuseCompanyAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('TaseeraUserBundle:UserOne')->find($id);
        $company->setAccepted(2);
        //$em->persist($company);
        $em->flush();
        $utilisateurs = array();
        $tab = array();
        $i = 0;
        $userOnes = $em->getRepository('TaseeraUserBundle:UserOne')->findAll();
        $users = $em->getRepository('TaseeraUserBundle:User')->findAll();
        foreach ($users as $user) {
            //var_dump($user);
            foreach ($userOnes as $userOne) {
                //var_dump($userOne);
                if ($userOne->getId() == $user->getId()) {
                    $utilisateurs[$i]['id'] = $user->getId();
                    $utilisateurs[$i]['sUsername'] = $user->getUsername();
                    $utilisateurs[$i]['sEmail'] = $user->getEmail();
                    $utilisateurs[$i]['accepted'] = $user->getAccepted();
                    $utilisateurs[$i]['image'] = $user->getImage();
                    $i++;
                }
            }
            $tab['data'] = $utilisateurs;
        }
        return $this->render('TaseeraBackendBundle:userone:index.html.twig', array(
            'userOnes' => $utilisateurs,
        ));
    }

    public function confirmCompanyAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('TaseeraUserBundle:UserOne')->find($id);
        $company->setAccepted(1);
        $em->flush();
        $utilisateurs = array();
        $tab = array();
        $i = 0;
        $userOnes = $em->getRepository('TaseeraUserBundle:UserOne')->findAll();
        $users = $em->getRepository('TaseeraUserBundle:User')->findAll();
        foreach ($users as $user) {
            //var_dump($user);
            foreach ($userOnes as $userOne) {
                //var_dump($userOne);
                if ($userOne->getId() == $user->getId()) {
                    $utilisateurs[$i]['id'] = $user->getId();
                    $utilisateurs[$i]['sUsername'] = $user->getUsername();
                    $utilisateurs[$i]['sEmail'] = $user->getEmail();
                    $utilisateurs[$i]['accepted'] = $user->getAccepted();
                    $utilisateurs[$i]['image'] = $user->getImage();
                    $i++;
                }
            }
            $tab['data'] = $utilisateurs;
        }
        return $this->render('TaseeraBackendBundle:userone:index.html.twig', array(
            'userOnes' => $utilisateurs,
        ));
    }
}

