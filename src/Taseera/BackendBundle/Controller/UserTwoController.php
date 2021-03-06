<?php

namespace Taseera\BackendBundle\Controller;

use Taseera\UserBundle\Entity\UserTwo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Usertwo controller.
 *
 */
class UserTwoController extends Controller
{
    /**
     * Lists all userTwo entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $userTwos = $em->getRepository('TaseeraUserBundle:UserTwo')->findAll();
        $users = $em->getRepository('TaseeraUserBundle:User')->findAll();
        $i = 0;
        $utilisateurs = array();
        $tab = array();
        foreach ($users as $user)
        {
            //var_dump($user);
            foreach ($userTwos as $userTwo){
                //var_dump($userOne);
                if($userTwo->getId()==$user->getId())
                {
                    $utilisateurs[$i]['id'] = $user->getId();
                    $utilisateurs[$i]['sUsername'] = $user->getUsername();
                    $utilisateurs[$i]['sEmail'] = $user->getEmail();
                    $i++;
                }
            }
            $tab['data'] = $utilisateurs;
        }

        return $this->render('TaseeraBackendBundle:usertwo:index.html.twig', array(
            'userTwos' => $utilisateurs,
        ));
    }

    /**
     * Creates a new userTwo entity.
     *
     */
    public function newAction(Request $request)
    {
        $userTwo = new Usertwo();
        $form = $this->createForm('Taseera\UserBundle\Form\UserTwoType', $userTwo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userTwo);
            $em->flush();

            return $this->redirectToRoute('usertwo_show', array('id' => $userTwo->getId()));
        }

        return $this->render('TaseeraBackendBundle:usertwo:new.html.twig', array(
            'userTwo' => $userTwo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a userTwo entity.
     *
     */
    public function showAction(UserTwo $userTwo)
    {
        $deleteForm = $this->createDeleteForm($userTwo);

        return $this->render('TaseeraBackendBundle:usertwo:show.html.twig', array(
            'userTwo' => $userTwo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing userTwo entity.
     *
     */
    public function editAction(Request $request, UserTwo $userTwo)
    {
        $deleteForm = $this->createDeleteForm($userTwo);
        $editForm = $this->createForm('Taseera\UserBundle\Form\UserTwoType', $userTwo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('usertwo_edit', array('id' => $userTwo->getId()));
        }

        return $this->render('TaseeraBackendBundle:usertwo:edit.html.twig', array(
            'userTwo' => $userTwo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a userTwo entity.
     *
     */
    public function deleteAction(Request $request, UserTwo $userTwo)
    {
        $form = $this->createDeleteForm($userTwo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userTwo);
            $em->flush();
        }

        return $this->redirectToRoute('usertwo_index');
    }

    /**
     * Creates a form to delete a userTwo entity.
     *
     * @param UserTwo $userTwo The userTwo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserTwo $userTwo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usertwo_delete', array('id' => $userTwo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function deleteNormalUserAction(Request $request, User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('usertwo_index');
    }
}
