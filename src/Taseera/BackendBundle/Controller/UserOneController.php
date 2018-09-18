<?php

namespace Taseera\UserBundle\Controller;

use Taseera\UserBundle\Entity\UserOne;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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

        $userOnes = $em->getRepository('TaseeraUserBundle:UserOne')->findAll();

        return $this->render('TaseeraUserBundle:userone:index.html.twig', array(
            'userOnes' => $userOnes,
        ));
    }

    /**
     * Creates a new userOne entity.
     *
     */
    public function newAction(Request $request)
    {
        $userOne = new Userone();
        $form = $this->createForm('Taseera\UserBundle\Form\UserOneType', $userOne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userOne);
            $em->flush();

            return $this->redirectToRoute('userone_show', array('id' => $userOne->getId()));
        }

        return $this->render('TaseeraUserBundle:userone:new.html.twig', array(
            'userOne' => $userOne,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a userOne entity.
     *
     */
    public function showAction(UserOne $userOne)
    {
        $deleteForm = $this->createDeleteForm($userOne);

        return $this->render('TaseeraUserBundle:userone:show.html.twig', array(
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

        return $this->render('TaseeraUserBundle:userone:edit.html.twig', array(
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
}
