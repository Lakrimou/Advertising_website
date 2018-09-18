<?php

namespace Taseera\CompanyBundle\Form\EventListener;


use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Taseera\BackendBundle\Entity\TCountry;
use Taseera\BackendBundle\Entity\TRegion;
use Taseera\BackendBundle\Entity\TCity;

class AddRegionFieldSubscriber implements EventSubscriberInterface
{
    private $propertyPathToModule;

    public function __construct($propertyPathToModule)
    {
        $this->propertyPathToModule = $propertyPathToModule;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT   => 'preSubmit'
        );
    }

    private function addTRegionForm($form, $tCountry_id, $tRegion = null)
    {
        $formOptions = array(
            'class'         => 'TaseeraBackendBundle:tRegion',
            'choices' => $tRegion,
            'mapped'        => false,
            'choice_label'=>'name',
            'choices_as_values' => true,
            'placeholder'   => 'tRegion',
            'attr'          => array(
                'class' => 'tRegion_selector',
            ),
            'query_builder' => function (EntityRepository $repository) use ($tCountry_id) {
                $qb = $repository->createQueryBuilder('tRegion')
                    ->innerJoin('tRegion.tCountry', 'tCountry')
                    ->where('tCountry.id = :tCountry')
                    ->setParameter('tCountry', $tCountry_id)
                ;

                return $qb;
            }
        );

        if ($tRegion) {
            $formOptions['data'] = $tRegion;
        }

        $form->add('tRegion', EntityType::class, $formOptions);
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $accessor = PropertyAccess::createPropertyAccessor();

        $tCity       = $accessor->getValue($data, $this->propertyPathToModule);
        $tRegion    = ($tCity) ? $tCity->getTRegion() : null;
        $tCountry_id  = ($tRegion) ? $tRegion->getCountry()->getId() : null;

        $this->addClasseForm($form, $tCountry_id, $tRegion);
    }

    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        $section_id = array_key_exists('tCountry', $data) ? $data['tCountry'] : null;

        $this->addClasseForm($form, $tCountry_id);
    }
}