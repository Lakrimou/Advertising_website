<?php

namespace Taseera\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Taseera\BackendBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Category controller.
 *
 */
class CategoryController extends Controller
{
    /**
     * Lists all category entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('TaseeraBackendBundle:Category')->findAll();

        return $this->render('TaseeraBackendBundle:category:index.html.twig', array(
            'categories' => $categories,
        ));
    }

    /**
     * Creates a new category entity.
     *
     */
    public function newAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm('Taseera\BackendBundle\Form\CategoryType', $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();


            $file = $category->getImage();
            $category->setImage($file); // Store the current value from the DB before overwriting below
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('category_directory'),
                $fileName
            );
            $category->setImage($fileName);

            $fileCover = $category->getCoverPicture();
            if($fileCover) {
                $category->setCoverPicture($fileCover); // Store the current value from the DB before overwriting below
                $fileNameCover = md5(uniqid()) . '.' . $fileCover->guessExtension();
                $fileCover->move(
                    $this->getParameter('category_directory_cover'),
                    $fileNameCover
                );
                $category->setCoverPicture($fileNameCover);
            }

            $em->persist($category);
            $em->flush();
            $session = $request->getSession();
            $session->getFlashBag()->add('msg', 'تم اضافة القسم بنجاح');
            return $this->redirectToRoute('category_index', array('id' => $category->getId()));
        }

        return $this->render('TaseeraBackendBundle:category:new.html.twig', array(
            'category' => $category,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a category entity.
     *
     */
    public function showAction(Category $category)
    {
        $deleteForm = $this->createDeleteForm($category);
        /*var_dump($category);
        die();*/
        return $this->render('TaseeraBackendBundle:category:show.html.twig', array(
            'category' => $category,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing category entity.
     *
     */
    public function editAction(Request $request, Category $category)
    {
        $deleteForm = $this->createDeleteForm($category);
        $editForm = $this->createForm('Taseera\BackendBundle\Form\EditCategoryType', $category);
        $editPictureForm = $this->createForm('Taseera\BackendBundle\Form\EditPictureCategoryType', $category);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted()/* && $editForm->isValid()*/) {
            $file = $category->getImage();
            $category->setImage($file);
            if($file instanceof UploadedFile)
            {
                // Store the current value from the DB before overwriting below
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move(
                    $this->getParameter('category_directory'),
                    $fileName
                );
                $category->setImage($fileName);
            }
                $this->getDoctrine()->getManager()->flush();
            if ($request->isXmlHttpRequest()) {

                return new JsonResponse(array('message' => 'Success!', 'success' => true), 200);

            }
            $session = $request->getSession();
            $session->getFlashBag()->add('msg', 'تم تعديل معلومات الطبيب  بنجاح');

            return $this->redirectToRoute('category_index');
        }

        return $this->render('TaseeraBackendBundle:category:edit.html.twig', array(
            'category' => $category,
            'edit_form' => $editForm->createView(),
            'editPictureForm' => $editPictureForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }






    public function editPictureCategoryAction(Request $request, Category $category)
    {
        $deleteForm = $this->createDeleteForm($category);
        $editPictureForm = $this->createForm('Taseera\BackendBundle\Form\EditPictureCategoryType', $category);
        $editForm = $this->createForm('Taseera\BackendBundle\Form\EditCategoryType', $category);
        $editPictureForm->handleRequest($request);
        if ($editPictureForm->isSubmitted()) {
            $file = $category->getImage();


            /*$this->container->getParameter('category_directory').'/'.$name;
            $success = file_put_contents($piiic, $data);
            if ($success) {
                unlink($this->container->getParameter('photoDoctor_directory') . '/' . $doctor->getPhotoDoctor());
                $doctor->setPhotoDoctor($name);
            }*/

            $category->setImage($file); // Store the current value from the DB before overwriting below
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('category_directory'),
                $fileName
            );
            $category->setImage($fileName);
            $this->getDoctrine()->getManager()->flush();
            if ($request->isXmlHttpRequest()) {

                return new JsonResponse(array('message' => 'Success!', 'success' => true, 'photo' => $category->getImage()), 200);

            }
            $session = $request->getSession();
            $session->getFlashBag()->add('msg', 'تم تعديل معلومات الطبيب  بنجاح');
            return $this->redirectToRoute('category_index');
        }
        return $this->render('TaseeraBackendBundle:category:edit.html.twig', array(
            'category' => $category,
            'edit_form' => $editForm->createView(),
            'editPictureForm' => $editPictureForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));

    }






    /**
     * Deletes a category entity.
     *
     */
    public function deleteAction(Request $request, Category $category)
    {
        $form = $this->createDeleteForm($category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush();
        }

        return $this->redirectToRoute('category_index');
    }

    /**
     * Creates a form to delete a category entity.
     *
     * @param Category $category The category entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Category $category)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('category_delete', array('id' => $category->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function deleteCategoryAction(Request $request, Category $category)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();
        return $this->redirectToRoute('category_index');
    }
}
