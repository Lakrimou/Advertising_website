<?php

namespace Taseera\UserBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditCompleteUserOneType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', FileType::class, array('label'=>'صورة الشركة', 'data_class'=>null))
            ->add('username', TextType::class, array('label'=>'اسم الشركة'))
            /*->add('password', RepeatedType::class, array(
            'type' => PasswordType::class,
            'invalid_message' => 'الرجاء ادخال نفس كلمة العبور',
            'required'=>true,
            'first_options'  => array('label' => 'كلمة العبور'),
            'second_options' => array('label' => 'اعادة كلمة العبور'),
            ))*/
            ->add('email', EmailType::class, array('label'=>'البريد الالكتروني'))
            ->add('description', TextareaType::class,array('label'=>'نبذة عن الشركة '))

            /*->add('categories', EntityType::class, array(
                'class'=>'TaseeraBackendBundle:Category',
                'placeholder'=>' ',
                'required'=>true,
                'choice_label'=>'nameCategory',
                'multiple'=>true,
                'label'=>'قسم'))*/
            ->add('categories', EntityType::class, array(
                'class'=>'TaseeraBackendBundle:Category',
                'placeholder'=>' ',
                'required'=>true,
                'query_builder'=>function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->where('u.subCategory != :value')->setParameter('value', "null");
                },
                'choice_label'=>'nameCategory',
                'multiple'=>true,
                'label'=>'قسم'))
            ->add('phoneNumber', NumberType::class,array('label'=>'رقم الجوال'))
            ->add('tCountry', EntityType::class, array(
                'class'=>'Taseera\BackendBundle\Entity\TCountry',
                'label'=>'البلد'
            ))
            ->add('tRegion', EntityType::class, array(
                'class'=>'Taseera\BackendBundle\Entity\TRegion',
                'label'=>'المدينة'))
            ->add('tCity', EntityType::class, array(
                'class'=>'Taseera\BackendBundle\Entity\TCity',
                'label'=>'الحي'))
            ->add('tCityArea', EntityType::class, array(
                'class'=>'Taseera\BackendBundle\Entity\TCityArea',
                'label'=>'الشارع'));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Taseera\UserBundle\Entity\UserOne'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'taseera_userbundle_userone';
    }


}
