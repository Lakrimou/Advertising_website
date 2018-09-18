<?php

namespace Taseera\BackendBundle\Controller;

use Taseera\BackendBundle\Entity\Item;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Taseera\BackendBundle\Entity\Media;

/**
 * Item controller.
 *
 */
class ItemController extends Controller
{
    /**
     * Lists all item entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $items = $em->getRepository('TaseeraBackendBundle:Item')->findAll();

        return $this->render('TaseeraBackendBundle:item:index.html.twig', array(
            'items' => $items,
        ));
    }

    /**
     * Creates a new item entity.
     *
     */
    public function newAction(Request $request)
    {
        $item = new Item();

        $form = $this->createForm('Taseera\BackendBundle\Form\ItemType', $item);
        /*$it = $request->request->all();
        var_dump($it);
        die();*/
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $attachments = $item->getMedias();
            /*var_dump($attachments);
            die();*/
            $item->setDatePub(new \DateTime());
            $item->setBSpam(0);
            $item->setBActive(1);
            $item->setBEnabled(1);
            $item->setBPremium(1);
            $ip = $request->getClientIp();
            $item->setSIp($ip);
            if ($attachments) {
                foreach($attachments as $attachment)
                {

                    $file = $attachment->getMedia();

                    //var_dump($attachment);
                    $filename = md5(uniqid()) . '.' .$file->guessExtension();

                    $file->move(
                        $this->getParameter('medias_directory'), $filename
                    );
                    //var_dump($filename);
                    $attachment->setMedia($filename);
                }}
            $em->persist($item);
            $em->flush();
            $session = $request->getSession();
            $session->getFlashBag()->add('msg', 'تم اضافة الاعلان بنجاح');
            return $this->redirectToRoute('item_index');
        }

        return $this->render('TaseeraBackendBundle:item:new.html.twig', array(
            'item' => $item,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a item entity.
     *
     */
    public function showAction(Item $item)
    {
        $deleteForm = $this->createDeleteForm($item);

        return $this->render('TaseeraBackendBundle:item:show.html.twig', array(
            'item' => $item,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing item entity.
     *
     */
    public function editAction(Request $request, Item $item)
    {
        $deleteForm = $this->createDeleteForm($item);
        $editForm = $this->createForm('Taseera\BackendBundle\Form\EditItemType', $item);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $attachments = $item->getMedias();
            /*var_dump($attachments);
            die();*/

            if ($attachments) {
                foreach($attachments as $attachment)
                {

                    $file = $attachment->getMedia();
                    if($file){
                    //var_dump($attachment);
                    $filename = md5(uniqid()) . '.' .$file->guessExtension();

                    $file->move(
                        $this->getParameter('medias_directory'), $filename
                    );
                    //var_dump($filename);
                    $attachment->setMedia($filename);
                }
                else{
                    $em = $this->getDoctrine()->getManager();
                    $id = $item->getId();
                    $itemOld = $em->getRepository('TaseeraBackendBundle:Item')->find($id);
                    $item->setMedias($itemOld->getMedias());
                }
                }}
            else{
                $em = $this->getDoctrine()->getManager();
                $id = $item->getId();
                $itemOld = $em->getRepository('TaseeraBackendBundle:Item')->find($id);
                $item->setMedias($itemOld->getMedias());
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('item_edit', array('id' => $item->getId()));
        }

        return $this->render('TaseeraBackendBundle:item:edit.html.twig', array(
            'item' => $item,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a item entity.
     *
     */
    public function deleteAction(Request $request, Item $item)
    {
        $form = $this->createDeleteForm($item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($item);
            $em->flush();
        }

        return $this->redirectToRoute('item_index');
    }

    /**
     * Creates a form to delete a item entity.
     *
     * @param Item $item The item entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Item $item)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('item_delete', array('id' => $item->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function deleteItemAction(Request $request, Item $item)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($item);
        $em->flush();
        return $this->redirectToRoute('item_index');
    }
}
