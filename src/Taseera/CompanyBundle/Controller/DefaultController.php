<?php

namespace Taseera\CompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\HttpFoundation\Request;
use Taseera\BackendBundle\Entity\Item;
use Taseera\BackendBundle\TaseeraBackendBundle;
use Taseera\UserBundle\Entity\User;
use Taseera\UserBundle\Entity\UserOne;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TaseeraCompanyBundle:Default:index.html.twig');
    }

    //list of items
    public function itemsCompanyAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $items = $em->getRepository('TaseeraBackendBundle:Item')->findBy(array(
            'userOne'=>$user
        ));
        return $this->render('TaseeraCompanyBundle:Default:items.html.twig', array(
            'items'=>$items
        ));
    }

    //profile company
    public function profileCompanyAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $testImage = false;
        $testCategories = false;
        if($user->getImage()){
            $testImage = true;
        };
        $categories = $user->getCategories();
        if($categories->isEmpty()){
            //dump('pas de categ');
            $testCategories = false;
        }else{

            $testCategories = true;
        }
        if($testCategories == false)
        {
            return $this->redirectToRoute('taseera_company_completeProfile');
        }
        $items = $em->getRepository('TaseeraBackendBundle:Item')->findBy(array(
            'userOne'=>$user
        ));
        $itemsNumber = 0;
        foreach($items as $item)
        {
            $itemsNumber++;
        }
        /*$deleteForm = $this->createDeleteForm($user);*/
        $editForm = $this->createForm('Taseera\UserBundle\Form\EditUserOneType', $user);
        $editPictureForm = $this->createForm('Taseera\UserBundle\Form\EditPictureUserOneFormType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted()) {
            $file = $user->getImage();
            $user->setImage($file);
            if($file instanceof UploadedFile) {
                // Store the current value from the DB before overwriting below
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move(
                    $this->getParameter('user_one_company_directory'),
                    $fileName
                );
                $user->setImage($fileName);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('taseera_company_profile');
        }

        return $this->render('TaseeraCompanyBundle:Default:profile.html.twig', array(
            'user'=>$user,
            'itemsNumber'=>$itemsNumber,
            'items'=>$items,
            'edit_form' => $editForm->createView(),
            'editPictureForm'=>$editPictureForm->createView()
            /*'delete_form' => $deleteForm->createView(),*/
        ));
    }

    public function editPictureCompanyAction(Request $request, UserOne $user)
    {
        /*$deleteForm = $this->createDeleteForm($user);*/
        $editPictureForm = $this->createForm('Taseera\UserBundle\Form\EditPictureUserOneFormType', $user);
        $editForm = $this->createForm('Taseera\UserBundle\Form\EditUserOneType', $user);
        $editPictureForm->handleRequest($request);
        if ($editPictureForm->isSubmitted()) {
            $file = $user->getImage();
            /*$this->container->getParameter('category_directory').'/'.$name;
            $success = file_put_contents($piiic, $data);
            if ($success) {
                unlink($this->container->getParameter('photoDoctor_directory') . '/' . $doctor->getPhotoDoctor());
                $doctor->setPhotoDoctor($name);
            }*/
            $user->setImage($file); // Store the current value from the DB before overwriting below
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('user_one_company_directory'),
                $fileName
            );
            $user->setImage($fileName);
            $this->getDoctrine()->getManager()->flush();
            if ($request->isXmlHttpRequest()) {

                return new JsonResponse(array('message' => 'Success!', 'success' => true, 'photo' => $user->getImage()), 200);

            }
            $session = $request->getSession();
            $session->getFlashBag()->add('msg', 'تم تعديل معلومات الطبيب  بنجاح');
            return $this->redirectToRoute('taseera_company_profile');
        }
        return $this->render('TaseeraCompanyBundle:Default:profile.html.twig', array(
            'userOne' => $user,
            'edit_form' => $editForm->createView(),
            'editPictureForm' => $editPictureForm->createView(),
            //'delete_form' => $deleteForm->createView(),
        ));

    }


    public function completeProfileCompanyAction(Request $request)
    {
        $user = $this->getUser();
        $editForm = $this->createForm('Taseera\UserBundle\Form\EditCompleteUserOneType', $user);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted()) {
            $file = $user->getImage();
            $user->setImage($file);
            // Store the current value from the DB before overwriting below
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('user_one_company_directory'),
                $fileName
            );
            $user->setImage($fileName);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('taseera_company_profile');
        }
        return $this->render('TaseeraCompanyBundle:Default:complete.html.twig', array(
            'user'=>$user,
            'edit_form' => $editForm->createView()));
    }




    /*    public function deleteAction(Request $request, UserOne $userOne)
        {
            $form = $this->createDeleteForm($userOne);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($userOne);
                $em->flush();
            }

            return $this->redirectToRoute('taseera_company_profile');
        }*/

    /**
     * Creates a form to delete a userOne entity.
     *
     * @param UserOne $userOne The userOne entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    /*    private function createDeleteForm(UserOne $user)
        {
            return $this->createFormBuilder()
                ->setAction($this->generateUrl('taseera_company_profile'))
                ->setMethod('DELETE')
                ->getForm()
                ;
        }*/

    /*public function deleteCompanyAction(Request $request, User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('taseera_company_profile');
    }*/

    //new Item
    public function newCompanyAction(Request $request)
    {
        $item = new Item();

        $form = $this->createForm('Taseera\BackendBundle\Form\ItemCompanyType', $item);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $attachments = $item->getMedias();

            date_default_timezone_set('Asia/Qatar');
            $dateNow = new \DateTime();
            $user = $this->getUser();
            $interval = new \DateInterval('P30D');
            $dateExpiration = $dateNow->add($interval);
            $ip = $request->getClientIp();
            $categories = $user->getCategories();
            foreach ($categories as $categorie)
            {
                $item->addCategory($categorie);
            }
            $item->setUserOne($user);
            $item->setDatePub(new \DateTime());
            $item->setBSpam(0);
            $item->setBActive(1);
            $item->setBEnabled(1);
            $item->setBPremium(1);
            $item->setDateExpiration($dateExpiration);
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
                }
            }

            $em->persist($item);
            $em->flush();
            $session = $request->getSession();
            $session->getFlashBag()->add('msg', 'تم اضافة الاعلان بنجاح');
            return $this->redirectToRoute('taseera_company_items');
        }
        return $this->render('TaseeraCompanyBundle:Default:newItem.html.twig', array(
            'item' => $item,
            'form' => $form->createView(),
        ));
    }

    //messages come for the company
    public function messageCompanyAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        /*dump($user);
        die();*/
        $messages = $em->getRepository('TaseeraBackendBundle:Messages')->findBy(array('userOne'=>$user));
        return $this->render('TaseeraCompanyBundle:Default:message.html.twig', array('messages'=>$messages));
    }

    //load notification for the company
    public function loadNotificationCompanyAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $notifications = $em->getRepository('TaseeraBackendBundle:Notification')->findBy(
            array(
                'userOne'=>$user,
                'seen'=>1),
            array('id'=>'desc'),
            5,
            0);
        $output = '';
        foreach ($notifications as $notification)
        {
            $output.= '
                      <li style="padding: 10px;">
                      <a href="'.$this->get('router')->generate('taseera_company_notification').'">
                      <strong>'.$notification->getNotification().'</strong><br />
                      <small><em>'.$notification->getDateNotification()->format("Y-M-D h:i").'</em></small>
                      </a>
                      </li>
                     
                      ';

        }
        $countNotification = count($notifications);
        /*dump($output);
        dump($countNotification);
        die();*/
        $result = array('notification'=>$output, 'count_notification'=>$countNotification);
        return new JsonResponse($result);
    }

    // Notifications
    public function notificationCompanyAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $notifications = $em->getRepository('TaseeraBackendBundle:Notification')->findBy(
            array('userOne'=>$user),
            array('id'=>'desc'));
        foreach ($notifications as $notification)
        {
            if($notification->getSeen() == 1)
            {
                $notification->setSeen(0);
                $em->persist($notification);
                $em->flush();
            }
        }
        return $this->render('TaseeraCompanyBundle:Default:notification.html.twig', array('notifications'=>$notifications));
    }

    public function showAdsInformationAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository('TaseeraBackendBundle:Item')->find($id);
        return $this->render('TaseeraCompanyBundle:Default:showItemInformation.html.twig', array('item'=>$item));
    }

    //modifier les informations de l'annonce
    public function editItemAction($id, Item $item, Request $request)
    {
        $deleteForm = $this->createDeleteForm($item);
        $editForm = $this->createForm('Taseera\BackendBundle\Form\EditItemCompanyType', $item);
        $editForm->handleRequest($request);
        $tab = array();

        $itemOls = $this->getDoctrine()->getManager()->getUnitOfWork()->getOriginalEntityData($item);


        $images = $itemOls['medias'];
        /*foreach ($images as $image)
        {
            dump($image->getMedia());
        }

        die();*/
        $i = 0;
        $j = 0;
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $attachments = $item->getMedias();
            /*var_dump($attachments);
            die();*/

            if ($attachments) {
                foreach($attachments as $attachment)
                {

                    $file = $attachment->getMedia();

                    /*dump(file_exists($file));
                    die();*/
                    if(file_exists($file)){
                        //var_dump($attachment);
                        $filename = md5(uniqid()) . '.' .$file->guessExtension();

                        $file->move(
                            $this->getParameter('medias_directory'), $filename
                        );
                        //var_dump($filename);
                        $attachment->setMedia($filename);
                    }
                    else{

                        $j = 0;
                        foreach ($images as $image)
                        {
                            if($j = $i) {
                                $attachment->setMedia($image->getMedia());
                            }
                            $j++;
                        }

                        //die();

                        /*$em = $this->getDoctrine()->getManager();
                        $id = $item->getId();
                        $itemOld = $em->getRepository('TaseeraBackendBundle:Item')->find($id);
                        $item->setMedias($itemOld->getMedias());*/
                    }
                    $i++;
                }
            }
            /*else{
                $em = $this->getDoctrine()->getManager();
                $id = $item->getId();
                $itemOld = $em->getRepository('TaseeraBackendBundle:Item')->find($id);
                $item->setMedias($itemOld->getMedias());
            }*/
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('taseera_edit_item', array('id' => $item->getId()));
        }

        return $this->render('TaseeraCompanyBundle:Default:editItem.html.twig', array(
            'item' => $item,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));

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
