<?php

namespace Taseera\BackendBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class CategoryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nameCategory', TextType::class, array('label'=>'اسم القسم'))
            ->add('description', TextareaType::class, array('label'=>'وصف القسم'))
            ->add('image', FileType::class, array('label'=>'صورة القسم', 'data_class'=>null, 'required'=>false))
            ->add('subCategory', EntityType::class, array(
            'class'=>'TaseeraBackendBundle:Category',
            'placeholder'=>' ',
            'required'=>false,
            'choice_label'=>'nameCategory',
            'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.subCategory is NULL')
                        ;},
            'label'=>'قسم الفرعي'))
            ->add('coverPicture', FileType::class, array('label'=>'صورة الغلاف', 'data_class'=>null, 'required'=>false));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Taseera\BackendBundle\Entity\Category'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'taseera_backendbundle_category';
    }


}
