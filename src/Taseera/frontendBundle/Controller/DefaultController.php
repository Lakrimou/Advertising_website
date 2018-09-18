<?php

namespace Taseera\frontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Taseera\BackendBundle\Entity\ViewsNumber;
use Taseera\UserBundle\Repository\UserOneRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Taseera\BackendBundle\Entity\Messages;
use Taseera\BackendBundle\Entity\Notification;
use Taseera\UserBundle\Entity\User;
use Taseera\UserBundle\Entity\UserOne;
use Taseera\UserBundle\Entity\UserTwo;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends Controller
{
    private function viewPageNumber(Request $request, $namePage)
    {
        $em = $this->getDoctrine()->getManager();
        date_default_timezone_set('Asia/Qatar');
        $ipAdr = $request->getClientIp();
        $pageUrl = $namePage;
        $userAgent = $request->headers->get('User-Agent');
        $viewNbr = 0;
        $lastIpDate = '';
        $pageUrlVue = '';
        $vue = $em->getRepository('Taseera\BackendBundle\Entity\ViewsNumber')->findBy(
            array('ipAdress'=>$ipAdr));
        if($vue)
        {

            //dump('je suis vue');
            foreach ($vue as $vu)
            {
                $lastIpDate = $vu->getDateAccess();
                $pageUrlVue = $vu->getPageUrl();
                //dump($pageUrlVue);
            }
            $currentDate = new \DateTime();
            $interval = new \DateInterval('PT12H');
            $afterTwelvelastIpDate = $lastIpDate->add($interval);
            if($currentDate < $afterTwelvelastIpDate)
            {
                if($pageUrlVue == $pageUrl){
                    $viewNotConsidered = "the view existed";
                   /* dump('pagekifkif');
                    dump($pageUrlVue);
                    dump($pageUrl);
                    die();*/
                    $securityContext = $this->container->get('security.authorization_checker');
                    if ($securityContext->isGranted('ROLE_USER')) {
                        foreach ($vue as $vu)
                        {
                            $emailUser = $vu->getEmailUsername();
                            if($emailUser == "guest")
                            {
                                $email = $this->getUser()->getEmail();
                                $vu->setEmailUsername($email);
                                $vu->setUserAgent($userAgent);
                                $em->flush();
                            }
                        }
                    }
                }else{
                    /*dump('page not kifkif');
                    die();*/
                    $viewNbr++;
                    $viewNumber = new ViewsNumber();
                    $viewNumber->setIpAdress($ipAdr);
                    $viewNumber->setViewNbr($viewNbr);
                    $currentDate = new \DateTime();
                    $viewNumber->setDateAccess($currentDate);
                    $viewNumber->setPageUrl($pageUrl);
                    $securityContext = $this->container->get('security.authorization_checker');
                    if ($securityContext->isGranted('ROLE_USER')) {
                        $email = $this->getUser()->getEmail();
                        $viewNumber->setEmailUsername($email);
                    }else{
                        $viewNumber->setEmailUsername('guest');
                    }
                    $viewNumber->setUserAgent($userAgent);
                    $em->persist($viewNumber);
                    $em->flush();
                }

            }else{
                /*dump('je peux ajoute vue avec la meme ip');
                die();*/
                $viewNbr++;
                $viewNumber = new ViewsNumber();
                $viewNumber->setIpAdress($ipAdr);
                $viewNumber->setViewNbr($viewNbr);
                $currentDate = new \DateTime();
                $viewNumber->setDateAccess($currentDate);
                $viewNumber->setPageUrl($pageUrl);
                $securityContext = $this->container->get('security.authorization_checker');
                if ($securityContext->isGranted('ROLE_USER')) {
                    $email = $this->getUser()->getEmail();
                    $viewNumber->setEmailUsername($email);
                }else{
                    $viewNumber->setEmailUsername('guest');
                }
                $viewNumber->setUserAgent($userAgent);
                $em->persist($viewNumber);
                $em->flush();
            }
        }else{
            /*dump('je ne suis pas vue');
            die();*/
            $viewNbr++;
            $viewNumber = new ViewsNumber();
            $viewNumber->setIpAdress($ipAdr);
            $viewNumber->setViewNbr($viewNbr);
            $currentDate = new \DateTime();
            $viewNumber->setDateAccess($currentDate);
            //$pageUrl = $request->getBaseUrl();
            $viewNumber->setPageUrl($pageUrl);
            $securityContext = $this->container->get('security.authorization_checker');
            if ($securityContext->isGranted('ROLE_USER')) {
                $email = $this->getUser()->getEmail();
                $viewNumber->setEmailUsername($email);
            }else{
                $viewNumber->setEmailUsername('guest');
            }
            $viewNumber->setUserAgent($userAgent);
            $em->persist($viewNumber);
            $em->flush();
        }
    }
    //Homepage
    public function indexAction(Request $request)
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('ROLE_COMPANY')) {
            return $this->redirectToRoute('company_logout');
        }
        $em = $this->getDoctrine()->getManager();
        $namePage = "homepage";
        $this->viewPageNumber($request, $namePage);
        $categories = $em->getRepository('Taseera\BackendBundle\Entity\Category')->findBy(array('subCategory'=>null));
        $regs = $em->getRepository('Taseera\BackendBundle\Entity\TRegion')->getRegionQatar();
        $regions = array();
        foreach ($regs as $reg)
        {
            $regions[]=$reg->getsName();
            $regions[]=$reg->getsSlug();
        }
        return $this->render('TaseerafrontendBundle:Default:index.html.twig', array('categories'=>$categories, 'regions'=>$regions));
    }

    //Recherche des items
    public function searchAction(Request $request)
    {
        $categorie = $request->request->get('category_name');
        $word = $request->request->get('word');
        $reg= $request->request->get('place');
        $user = $request->request->get('user');
        $em = $this->getDoctrine()->getManager();
        $namePage = "searchpage";
        $this->viewPageNumber($request, $namePage);
        $regi = $em->getRepository('Taseera\BackendBundle\Entity\TRegion')->findBy(array('sSlug'=>$reg));
        $region = '';
        foreach ($regi as $re)
        {
            $region = $re->getId();
        }
        $results = $em->getRepository('Taseera\BackendBundle\Entity\Item')->getResults($word, $categorie, $user, $region);
        return $this->render('TaseerafrontendBundle:Default:search.html.twig', array('results'=>$results));
    }

    //all categories
    public function allCategoriesAction(Request $request)
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('ROLE_COMPANY')) {
            return $this->redirectToRoute('company_logout');
        }
        $em = $this->getDoctrine()->getManager();
        $namePage="categoriesPage";
        $this->viewPageNumber($request, $namePage);
        $categories = $em->getRepository('Taseera\BackendBundle\Entity\Category')->findBy(array('subCategory'=>null));
        return $this->render('TaseerafrontendBundle:Default:categories.html.twig', array('categories'=>$categories));
    }
    
    //About us
    public function aboutUsAction(Request $request)
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('ROLE_COMPANY')) {
            return $this->redirectToRoute('company_logout');
        }
        $namePage = "aboutUsPage";
        $this->viewPageNumber($request, $namePage);
        return $this->render('TaseerafrontendBundle:Default:aboutUs.html.twig');
    }

    //contact us
    public function contactUsAction(Request $request)
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('ROLE_COMPANY')) {
            return $this->redirectToRoute('company_logout');
        }
        $namePage = "contactUsPage";
        $this->viewPageNumber($request, $namePage);
        return $this->render('TaseerafrontendBundle:Default:contactUs.html.twig');
    }

    //sub categories
    public function subCategoryAction($id, Request $request)
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('ROLE_COMPANY')) {
            return $this->redirectToRoute('company_logout');
        }
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository('Taseera\BackendBundle\Entity\Category')->find($id);
        $namePage = $category->getNameCategory();
        $this->viewPageNumber($request, $namePage);
        $threeCats = $em->getRepository('Taseera\BackendBundle\Entity\Category')->findBy(array(),array('id'=>'desc'),3 , 0);
        $subcategories = $em->getRepository('Taseera\BackendBundle\Entity\Category')->findBy(array('subCategory'=>$category));
        return $this->render('TaseerafrontendBundle:Default:subcategories.html.twig', array('category'=>$category, 'subcategories'=>$subcategories,'threeCats'=>$threeCats));
    }

    //adds for specific company
    public function addsCompanyAction($id, $id_category, Request $request)
    {
        /*$securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('ROLE_COMPANY')) {
            return $this->redirectToRoute('company_logout');
        }
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }*/
        $em = $this->getDoctrine()->getManager();
        $sub_category = $em->getRepository('Taseera\BackendBundle\Entity\Category')->find($id_category);
        $category = $em->getRepository('Taseera\BackendBundle\Entity\Category')->find($sub_category->getSubCategory());
        $company = $em->getRepository('Taseera\UserBundle\Entity\UserOne')->find($id);
        $items = $em->getRepository('Taseera\BackendBundle\Entity\Item')->findBy(array('userOne'=>$company));
        $pageName = "ads_companyPage_".$company->getId();
        $this->viewPageNumber($request, $pageName);
        return $this->render('TaseerafrontendBundle:Default:companyAdds.html.twig', array('company'=>$company, 'sub_category'=>$sub_category, 'category'=>$category,'items'=>$items));
    }

    //companies
    public function companiesAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $subcategory = $em->getRepository('Taseera\BackendBundle\Entity\Category')->find($id);
        $namePage = $subcategory->getNameCategory();
        $category = $em->getRepository('Taseera\BackendBundle\Entity\Category')->find($subcategory->getSubCategory());
        $cat = $category->getId();
        $this->viewPageNumber($request, $namePage);
        $companies = $em->getRepository('TaseeraUserBundle:UserOne')->getCompany($cat, $id);
        return $this->render('TaseerafrontendBundle:Default:companies.html.twig', array(
            'subcategory'=>$subcategory,
            'companies'=>$companies));
    }

    //send Emails for companies if specific subCategory
    public function sendMailsAction($id, Request $request)
    {
        $emailSender = $request->request->get('email');
        $msge = $request->request->get('msg');
        $subject = $request->request->get('subject');
        $identiantUser = $request->request->get('identifiantUser');
        /*var_dump($email);
        var_dump($msg);
        var_dump($subject);
        die();*/
        $em = $this->getDoctrine()->getManager();
        /*$category = $em->getRepository('Taseera\BackendBundle\Entity\Category')->find($id)*/;
        $subcategory = $em->getRepository('Taseera\BackendBundle\Entity\Category')->find($id);
        /*dump($subcategory);
        dump($id);*/
        $category = $em->getRepository('Taseera\BackendBundle\Entity\Category')->find($subcategory->getSubCategory());
        /*dump($category->getId());*/
        $cat = $category->getId();
        $companies = $em->getRepository('TaseeraUserBundle:UserOne')->getCompany($cat, $id);
        /*var_dump($companies);
        die();*/
        /*dump($companies);
        die();*/
        $emails = array();
        foreach ($companies as $company )
        {
            $mess = new Messages();
            /*dump($this->getUser());
            die();*/
            //$id = $this->getUser()->getId();
            $userTwo = $em->getRepository('Taseera\UserBundle\Entity\UserTwo')->find($identiantUser);
            $mess->setUserTwo($userTwo);
            $mess->setUserOne($company);
            $mess->setSubject($subject);
            $mess->setMessage($msge);
            $mess->setPublicationDate(new \DateTime());
            $notification = new Notification();
            $notification->setNotification('لديك رسالة جديدة من '.$this->getUser());
            $notification->setSeen(1);
            $notification->setDateNotification(new \DateTime());
            $notification->setUserOne($company);
            $notification->setUserTwo($this->getUser());
            $notification->setMessage($mess);
            $em->persist($mess);
            $em->persist($notification);
            $em->flush();
            $emails[]=$company->getEmail();
        }
        $msg = $msge;


        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
            ->setUsername('hr.direction.tassaira@gmail.com')
            ->setPassword('Abouali123456');

        $mailer = \Swift_Mailer::newInstance($transport);
        $message = \Swift_Message::newInstance($msg)
            ->setFrom('akrem.boussaha@gmail.com')
            ->setTo($emails)
            ->setBody($subject. "\n\n" .$emailSender. "\n\n" . $msg);
        $mailer->send($message);
        if ($this->get('mailer')->send($message))
        {
            return new JsonResponse(array('success'=>1, 'message' => 'تم إرسال رسالتك', 'error'=>0));
        }
        else
        {
            return new JsonResponse(array('success'=>0, 'error'=>1, 'message'=>'لم يتم إرسال رسالتك'));

        }
    }

    //detail of specific ad for specific company
    public function itemsAction($id, $id_category, $id_item, Request $request)
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('ROLE_COMPANY')) {
            return $this->redirectToRoute('company_logout');
        }
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();

        //$this->viewPageNumber($request);
        $sub_category = $em->getRepository('Taseera\BackendBundle\Entity\Category')->find($id_category);
        $category = $em->getRepository('Taseera\BackendBundle\Entity\Category')->find($sub_category->getSubCategory());
        $company = $em->getRepository('Taseera\UserBundle\Entity\UserOne')->find($id);
        $items = $em->getRepository('Taseera\BackendBundle\Entity\Item')->findBy(array('id'=>$id_item,'userOne'=>$company));
        $identifiant=0;
        foreach ($items as $item)
        {
            $identifiant = $item->getId();
        }
        //the id of the item
        $namePage = $identifiant;
        $this->viewPageNumber($request, $namePage);
        return $this->render('TaseerafrontendBundle:Default:items.html.twig', array('company'=>$company, 'sub_category'=>$sub_category, 'category'=>$category,'items'=>$items));
    }

    public function switchlanguageAction($locale, Request $request) {

        /*dump($url);
        dump($request->getRequestUri());
        die();*/
        if($locale != null)
        {
            // On enregistre la langue en session

            $this->get('session')->set('_locale', $locale);
        }

        // on tente de rediriger vers la page d'origine
        $url = $request->headers->get('referer');
        /*$ab = $request->getBaseUrl();
        dump($ab);*/

        if(empty($url))
        {

            $url = $this->container->get('router')->generate('taseerafrontend_homepage');
        }

        return new RedirectResponse($url);
    }

    //send message for a specific company who has a specific adds
    public function contactAction(Request $request)
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('ROLE_COMPANY')) {
            return $this->redirectToRoute('company_logout');
        }
        $em = $this->getDoctrine()->getManager();
        $name = $request->request->get('contactName');
        $mail = $request->request->get('email');
        $objet = $request->request->get('comments');
        $message = $request->request->get('message');
        $contactEmail = $request->request->get('contactEmail');
        $subcategory = $request->request->get('subcategory');
        $id_company = $request->request->get('id_company');
        $identiantUser = $request->request->get('identifiantUser');
        $company = $em->getRepository('Taseera\UserBundle\Entity\UserOne')->find($id_company);


        $mess = new Messages();
        $userTwo = $em->getRepository('Taseera\UserBundle\Entity\UserTwo')->find($identiantUser);
        $mess->setUserTwo($userTwo);
        $mess->setUserOne($company);
        $mess->setSubject($objet);
        $mess->setMessage($message);
        $mess->setPublicationDate(new \DateTime());
        $notification = new Notification();
        $notification->setNotification('لديك رسالة جديدة من '.$userTwo);
        $notification->setSeen(1);
        $notification->setDateNotification(new \DateTime());
        $notification->setUserOne($company);
        $notification->setUserTwo($userTwo);
        $notification->setMessage($mess);
        $em->persist($mess);
        $em->persist($notification);
        $em->flush();


        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
            ->setUsername('hr.direction.tassaira@gmail.com')
            ->setPassword('Abouali123456');

        $mailer = \Swift_Mailer::newInstance($transport);
        $message = \Swift_Message::newInstance($objet)
            ->setFrom('direction.tassaira@gmail.com')
            ->setTo(['hr.direction.tassaira@gmail.com', $contactEmail])
            ->setBody($name. "\n\n" .$mail. "\n\n" .$objet. "\n\n". $message."\n\n   ايميل الشركة ".$contactEmail);



        if ($this->get('mailer')->send($message))
        {
            $session = $request->getSession();
            //{{ path('taseerafrontend_adds', {'id':company.id, 'id_category':subcategory.id }) }}
            /*$url = $this->get('router')->generate(
                'taseerafrontend_adds', // 1er argument : le nom de la route
                array('id' => $id_company, 'id_category'=>$subcategory)
                UrlGeneratorInterface::ABSOLUTE_URL// 2e argument : les valeurs des paramètres
            );*/
            $session->getFlashBag()->add('msg', 'تم ارسال رسالتك بنجاح');

            return $this->redirectToRoute('taseerafrontend_adds', array('id' => $id_company, 'id_category'=>$subcategory));
        }
        else
        {
            $session = $request->getSession();
            /*$url = $this->get('router')->generate(
                'taseerafrontend_adds', // 1er argument : le nom de la route
                array('id' => $id_company, 'id_category'=>$subcategory)
                UrlGeneratorInterface::ABSOLUTE_URL// 2e argument : les valeurs des paramètres
            );*/
            $session->getFlashBag()->add('msg', 'لم يتم إرسال رسالتك');
            return $this->redirectToRoute('taseerafrontend_adds', array('id' => $id_company, 'id_category'=>$subcategory));

        }

    }

    //User profile
    public function profileUserAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();
        $namePage = 'profilePage';
        $this->viewPageNumber($request, $namePage);
        $user = $this->getUser();
        return $this->render('TaseerafrontendBundle:Default:profileUser.html.twig', array('user'=>$user));
    }

    public function contctUsAction(Request $request)
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('ROLE_COMPANY')) {
            return $this->redirectToRoute('company_logout');
        }
        $name = $request->request->get('contactName');
        $mail = $request->request->get('email');
        $phone = $request->request->get('phone');
        $objet = $request->request->get('subject');
        $message = $request->request->get('comments');

        /*dump($name);
        dump($mail);
        dump($objet);
        dump($message);
        dump($contactEmail);
        die();*/
        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
            ->setUsername('hr.direction.tassaira@gmail.com')
            ->setPassword('Abouali123456');

        $mailer = \Swift_Mailer::newInstance($transport);
        $message = \Swift_Message::newInstance($objet)
            ->setFrom('direction.tassaira@gmail.com')
            ->setTo(['hr.direction.tassaira@gmail.com' => 'Receiver Name'])
            ->setBody($name. "\n\n" .$mail. "\n\n" . $message. "\n\n" .$phone);

        if ($this->get('mailer')->send($message))
        {
            $session = $request->getSession();
            $session->getFlashBag()->add('msg', 'تم ارسال رسالتك بنجاح');
            return $this->redirectToRoute('taseerafrontend_contactUs');
        }
        else
        {
            $session = $request->getSession();
            $session->getFlashBag()->add('msg', 'لم يتم إرسال رسالتك');
            return $this->redirectToRoute('taseerafrontend_contactUs');

        }

    }

    public function completeProfileUserAction(Request $request)
    {
        $user = $this->getUser();
        $editForm = $this->createForm('Taseera\UserBundle\Form\EditCompleteUserTwoType', $user);
        $editPictureFormm = $this->createForm('Taseera\UserBundle\Form\EditPictureUserTwoFormType', $user);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted()) {
            /*$file = $user->getImage();
            $user->setImage($file);
            // Store the current value from the DB before overwriting below
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('user_two_directory'),
                $fileName
            );
            $user->setImage($fileName);*/

            $this->getDoctrine()->getManager()->flush();
            $session = $request->getSession();
            $session->getFlashBag()->add('msg', 'تم تحديث ملفك الشخصي بنجاح');
            return $this->redirectToRoute('taseerafrontend_completeProfileUser');
        }
        $namePage = "completeProfile";
        $this->viewPageNumber($request, $namePage);
        return $this->render('TaseerafrontendBundle:Default:completeUser.html.twig', array(
            'user'=>$user,
            'edit_form' => $editForm->createView(),
            'editPictureFormm'=>$editPictureFormm->createView()));
    }


    public function editPictureUserAction(Request $request, UserTwo $user)
    {

        $editPictureFormm = $this->createForm('Taseera\UserBundle\Form\EditPictureUserTwoFormType', $user);
        $editForm = $this->createForm('Taseera\UserBundle\Form\EditCompleteUserTwoType', $user);
        $editPictureFormm->handleRequest($request);
        if ($editPictureFormm->isSubmitted()) {
            $file = $user->getImage();
            $user->setImage($file); // Store the current value from the DB before overwriting below
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('user_two_directory'),
                $fileName
            );
            $user->setImage($fileName);
            $this->getDoctrine()->getManager()->flush();
            if ($request->isXmlHttpRequest()) {

                return new JsonResponse(array('message' => 'Success!', 'success' => true, 'photo' => $user->getImage()), 200);

            }
            $session = $request->getSession();
            $session->getFlashBag()->add('msg', 'تم تعديل معلومات الطبيب  بنجاح');
            return $this->redirectToRoute('taseerafrontend_profileUser');
        }
        return $this->render('TaseerafrontendBundle:Default:completeUser.html.twig', array(
            'userTwo' => $user,
            'edit_form' => $editForm->createView(),
            'editPictureFormm' => $editPictureFormm->createView(),
            //'delete_form' => $deleteForm->createView(),
        ));

    }


}
