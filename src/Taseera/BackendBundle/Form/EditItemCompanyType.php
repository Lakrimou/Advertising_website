<?php

namespace Taseera\BackendBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Taseera\BackendBundle\Repository\CategoryRepository;

class EditItemCompanyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nameItem')
            ->add('description')
            ->add('price')
            ->add('categories', EntityType::class, array(
            'class'=>'TaseeraBackendBundle:Category',
            'placeholder'=>' ',
            'required'=>true,
            'choice_label'=>'nameCategory',
                'multiple'=>true,
            'label'=>'قسم'))
            ->add('medias', CollectionType::class, array(
                'required'=>false,
                'entry_type'=>MediaType::class,
                'allow_add'=>true,
                'by_reference'=>false,
                'label'=>' '
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Taseera\BackendBundle\Entity\Item'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'taseera_backendbundle_item';
    }
}
