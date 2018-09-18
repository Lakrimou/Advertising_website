<?php

namespace Taseera\UserBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditCompleteUserTwoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
                'label'=>'اسم المستخدم',
                'translation_domain' => 'messages'))
            ->add('email', EmailType::class, array(
                'label'=>'البريد الإلكتروني',
                'translation_domain' => 'messages'))
            ->add('phoneNumber', NumberType::class,array(
                'label'=>'رقم الجوال',
                'translation_domain'=>'messages'
            ))
            ->add('facebook', UrlType::class, array('label'=>'الفايسبوك'))
            ->add('twitter', UrlType::class, array('label'=>'التويتر'))
            ->add('googlePlus', UrlType::class, array('label'=>'غوغل بلاس'))
            ->add('tCountry', EntityType::class, array(
                'class'=>'Taseera\BackendBundle\Entity\TCountry',
                'label'=>'البلد',
                'translation_domain' => 'messages'
            ))
            ->add('tRegion', EntityType::class, array(
                'class'=>'Taseera\BackendBundle\Entity\TRegion',
                'label'=>'المدينة',
                'translation_domain' => 'messages'))
            ->add('tCity', EntityType::class, array(
                'class'=>'Taseera\BackendBundle\Entity\TCity',
                'label'=>'الحي',
                'translation_domain' => 'messages'));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Taseera\UserBundle\Entity\UserTwo'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'taseera_userbundle_usertwo';
    }


}
