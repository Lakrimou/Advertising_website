<?php

namespace Taseera\EndpointBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Patch;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Taseera\BackendBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Nelmio\ApiDocBundle\Annotation as Doc;
use Taseera\BackendBundle\Entity\Item;
use Taseera\BackendBundle\Entity\Media;
use Taseera\BackendBundle\Form\CategoryType;
use Taseera\BackendBundle\Form\ItemCompanyType;
use Taseera\UserBundle\Entity\UserOne;
use Taseera\UserBundle\Form\UserOneType;

class DefaultController extends Controller
{
    /**
     * @Get(
     *     path = "/categories",
     *     name = "app_article_show",
     * )
     * @View
     * @Doc\ApiDoc(
     *     resource=true,
     *     description="list categories"
     * )

     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('Taseera\BackendBundle\Entity\Category')->findBy(array('subCategory'=>null));

        return $categories;
    }

    /**
     * @Get(
     *     path = "/category/{id}",
     *     name = "app_specific_category",
     * )
     * @View
     * @Doc\ApiDoc(
     *     resource=true,
     *     description="get specific category"
     * )

     */
    public function getSpecificCategoryAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('Taseera\BackendBundle\Entity\Category')->find($id);
        $subcategories = $em->getRepository('Taseera\BackendBundle\Entity\Category')->findBy(array('subCategory'=>$category));
        return $subcategories;
    }

    /**
     * @Get(
     *     path = "/{id}/companies",
     *     name = "app_specific_companies",
     * )
     * @View
     * @Doc\ApiDoc(
     *     resource=true,
     *     description="get Companies"
     * )

     */
    public function getCompaniesAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $subcategory = $em->getRepository('Taseera\BackendBundle\Entity\Category')->find($id);
        $category = $em->getRepository('Taseera\BackendBundle\Entity\Category')->find($subcategory->getSubCategory());
        $cat = $category->getId();
        $companies = $em->getRepository('TaseeraUserBundle:UserOne')->getCompany($cat, $id);
        return $companies;
    }

    /**
     * @Get(
     *     path = "/{id}/{id_category}/ads-company",
     *     name = "app_ads_companies",
     * )
     * @View
     * @Doc\ApiDoc(
     *     resource=true,
     *     description="get Ads Company"
     * )

     */
    public function getAdsCompanyAction($id, $id_category)
    {
        $em = $this->getDoctrine()->getManager();
        $sub_category = $em->getRepository('Taseera\BackendBundle\Entity\Category')->find($id_category);
        $category = $em->getRepository('Taseera\BackendBundle\Entity\Category')->find($sub_category->getSubCategory());
        $company = $em->getRepository('Taseera\UserBundle\Entity\UserOne')->find($id);
        $ads = $em->getRepository('Taseera\BackendBundle\Entity\Item')->findBy(array('userOne'=>$company));
        return $ads;
    }

    /**
     * @Get(
     *     path = "/{id}/{id_category}/{id_item}/advert",
     *     name = "app_detail_ad_companies",
     * )
     * @View
     * @Doc\ApiDoc(
     *     resource=true,
     *     description="get Detail ad"
     * )

     */
    public function getDetailAdAction($id, $id_category, $id_item)
    {
        $em = $this->getDoctrine()->getManager();
        $sub_category = $em->getRepository('Taseera\BackendBundle\Entity\Category')->find($id_category);
        $category = $em->getRepository('Taseera\BackendBundle\Entity\Category')->find($sub_category->getSubCategory());
        $company = $em->getRepository('Taseera\UserBundle\Entity\UserOne')->find($id);
        $items = $em->getRepository('Taseera\BackendBundle\Entity\Item')->findBy(array('id'=>$id_item,'userOne'=>$company));
        return $items;
    }

    /**
     * @Get(
     *     path = "/{id}/company",
     *     name = "app_specific-company",
     * )
     * @View
     * @Doc\ApiDoc(
     *     resource=true,
     *     description="get Company"
     * )

     */
    public function getUserOne($id)
    {
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('Taseera\UserBundle\Entity\UserOne')->find($id);
        return $company;
    }

    /**
     * @Get(
     *     path = "/{id}/user",
     *     name = "app_specific-user",
     * )
     * @View
     * @Doc\ApiDoc(
     *     resource=true,
     *     description="get user"
     * )

     */
    public function getUserApp($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('Taseera\UserBundle\Entity\User')->find($id);
        return $user;
    }

    /**
     * @Get(
     *     path = "/{id}/complete-company",
     *     name = "app_complete_profile",
     * )
     * @View
     * @Doc\ApiDoc(
     *     resource=true,
     *     description="get complete profile"
     * )

     */
    public function completeProfileCompany($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('Taseera\UserBundle\Entity\UserOne')->find($id);
        $categories = $company->getCategories();
        $completed = false;
        $image = $company->getImage();
        $company_detail = array();
        foreach ($categories as $category)
        {
            if($category)
            {
                $completed = true;
                break;

            }else{
                $completed = false;
            }
        }
        if($completed == true and !empty($image)){
            $company_detail['completed'] = 1;
            $company_detail['id'] = $company->getId();
            $company_detail['username'] = $company->getUsername();
            $company_detail['email'] = $company->getEmail();
            //$company_detail['type'] = $company->getType();
            $company_detail['accepted'] = $company->getAccepted();
            $company_detail['enabled'] = $company->isEnabled();
            $company_detail['type'] = 'user_one';
        }else{
            $company_detail['completed'] = 0;
            $company_detail['id'] = $company->getId();
            $company_detail['username'] = $company->getUsername();
            $company_detail['email'] = $company->getEmail();
            //$company_detail['type'] = $company->getType();
            $company_detail['accepted'] = $company->getAccepted();
            $company_detail['enabled'] = $company->isEnabled();
            $company_detail['type'] = 'user_one';
        }
        return $company_detail;
    }

    /**
     * @Get(
     *     path = "/{id}/user",
     *     name = "app_specific-user",
     * )
     * @View
     * @Doc\ApiDoc(
     *     resource=true,
     *     description="getUser",
     *     requirements={
     *         {
     *             "name"="id",
     *             "dataType"="integer",
     *             "requirements"="\d+",
     *             "description"="The user unique identifier."
     *         }
     *     }
     * )
     */
    public function getUserTwo($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('Taseera\UserBundle\Entity\UserTwo')->find($id);
        return $user;
    }

    /**
     * @Post("/add-category", name="app_add_category")
     * @View(StatusCode = 201)
     * @Doc\ApiDoc(
     *     resource=true,
     *     description="add Category"
     * )

     */
    public function addCategoryAction(Request $request)
    {
        $data = $this->get('jms_serializer')->deserialize($request->getContent(), 'array', 'json');
        $category = new Category();
        $form = $this->get('form.factory')->create(CategoryType::class, $category);
        $form->submit($data);

        $em = $this->getDoctrine()->getManager();

        /*dump($category);
        die();*/
        return $this->view($category, Response::HTTP_CREATED, ['Location' => $this->generateUrl('app_article_show', ['id' => $article->getId()])]);
    }

    /**
     * @Post("/add-ad/{id}", name="app_add_ad")
     * @View(StatusCode = 201)
     * @Doc\ApiDoc(
     *     resource=true,
     *     description="add Item"
     * )

     */
    public function addItemAction(Request $request, $id)
    {
        $data = $this->get('jms_serializer')->deserialize($request->getContent(), 'array', 'json');
        $item = new Item();
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository("Taseera\UserBundle\Entity\UserOne")->find($id);
        $item->setUserOne($company);
        $categories = $company->getCategories();
        foreach ($categories as $categorie)
        {
            $item->addCategory($categorie);
        }
        date_default_timezone_set('Asia/Qatar');
        $dateNow = new \DateTime();
        $item->setDatePub(new \DateTime());
        $interval = new \DateInterval('P30D');
        $dateExpiration = $dateNow->add($interval);
        $item->setDateExpiration($dateExpiration);

        $item->setBSpam(0);
        $item->setBActive(1);
        $item->setBEnabled(1);
        $item->setBPremium(1);
        $item->setBShowEmail(1);
        $item->setContactEmail($company->getEmail());
        $item->setContactName($company->getUsername());
        $ip = $request->getClientIp();
        $item->setSIp($ip);

        $form = $this->get('form.factory')->create(ItemCompanyType::class, $item);
        $form->submit($data);

        $media1 = $request->request->get('media1');
        $media2 = $request->request->get('media2');
        $media3 = $request->request->get('media3');
        $medias = array($media1, $media2, $media3);
        $attachments = $medias;
        foreach ($attachments as $attachment)
        {
            //dump($attachment);
            str_replace(' ', '+', $attachment);
            $data = base64_decode($attachment);
            $name = uniqid() . '.png';
            $piiic = $this->container->getParameter('medias_directory').'/'.$name;
            $success = file_put_contents($piiic, $data);
            if($success)
            {
                $media = new Media();
                $media->setMedia($name);
                $item->addMedia($media);
                $em->persist($media);
            }
        }
        $em->persist($item);
        $em->flush();

        return $item;
    }

    /**
     * @Patch("/company-complete-profile/{id}", name="company_complete_profile")
     * @View(StatusCode = 201)
     * @Doc\ApiDoc(
     *     resource=true,
     *     description="complete profile company"
     * )
     */
    public function companyCompleteProfileAction(Request $request, $id)
    {
        $data = $this->get('jms_serializer')->deserialize($request->getContent(), 'array', 'json');
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository("Taseera\UserBundle\Entity\UserOne")->find($id);
        $form = $this->get('form.factory')->create(UserOneType::class, $company);
        $form->submit($data, false);
        /*$em->merge($company);
        $em->flush();*/
        $phoneNumber = $request->request->get('phoneNumber');
        /*dump($phoneNumber);
        die();*/
        $description = $request->request->get('description');
        $id_category= $request->request->get('id_category');
        $category = $em->getRepository("Taseera\BackendBundle\Entity\Category")->find($id_category);
        $country_id = $request->request->get('country_id');
        $country = $em->getRepository("Taseera\BackendBundle\Entity\TCountry")->find($country_id);
        $region_id = $request->request->get('region_id');
        $region = $em->getRepository("Taseera\BackendBundle\Entity\TRegion")->find($region_id);
        /*$city_id = $request->request->get('city_id');
        $city = $em->getRepository("Taseera\BackendBundle\Entity\TRegion")->find($city_id);*/
        $image = $request->request->get('image');
        str_replace(' ', '+', $image);
        $data = base64_decode($image);
        $name = uniqid() . '.png';
        $image = $this->container->getParameter('user_one_company_directory').'/'.$name;
        $success = file_put_contents($image, $data);
        if($success) {
            $company->setPhoneNumber($phoneNumber);
            $company->setDescription($description);
            $company->addCategory($category);
            $company->setTCountry($country);
            $company->setTRegion($region);
            $company->setImage($image);
            /*$company->setTCity($city);*/
            $em->merge($company);
            $em->flush();
            $entityManager = $this->getDoctrine()->getManager();
            $company = $entityManager->getRepository("Taseera\UserBundle\Entity\UserOne")->find($id);
            return $company;
        }
        else{
            $response['error'] = 1;
            return $response;
        }
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


}
