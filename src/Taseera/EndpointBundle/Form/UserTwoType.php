<?php

namespace Taseera\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserTwoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', TextType::class, array('label'=>'اسم المستخدم'))
            /*->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'الرجاء ادخال نفس كلمة العبور',
                'required'=>true,
                'first_options'  => array('label' => 'كلمة العبور'),
                'second_options' => array('label' => 'اعادة كلمة العبور'),
            ))*/
            ->add('email', EmailType::class, array('label'=>'البريد الالكتروني'))
            ->add('image', FileType::class, array('label'=>'صورة المستخدم', 'data_class'=>null))
            ->add('tCountry')->add('tRegion')->add('tCity')->add('tCityArea');
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
