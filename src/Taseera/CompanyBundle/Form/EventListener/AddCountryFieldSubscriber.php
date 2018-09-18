<?php

namespace Taseera\CompanyBundle\Form\EventListener;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Taseera\BackendBundle\Entity\TCountry;
use Taseera\BackendBundle\Entity\TRegion;
use Taseera\BackendBundle\Entity\TCity;

class AddCountryFieldSubscriber implements EventSubscriberInterface
{
    private $propertyPathToModule;

    public function __construct($propertyPathToModule)
    {
        $this->propertyPathToModule = $propertyPathToModule;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA =>'preSetData',
            FormEvents::PRE_SUBMIT    => 'preSubmit'
        );
    }

    private function addTCountryForm($form, $tCountry = null)
    {
        $formOptions = array(
            'class'         => 'TaseeraBackendBundle:TCountry',
            'choices' => $tCountry,
            'mapped'        => false,
            'choice_label'=>'name',
            'choices_as_values' => true,
            'label'         => 'Country',
            'placeholder'   => 'Country',
            'attr'          => array(
                'class' => 'tCountry_selector',
            ),
        );

        if ($tCountry) {
            $formOptions['data'] = $tCountry;
        }

        $form->add('tCountry', EntityType::class, $formOptions);
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $accessor = PropertyAccess::createPropertyAccessor();

        $module    = $accessor->getValue($data, $this->propertyPathToModule);
        $section = ($module) ? $module->getClasse()->getSection() : null;

        $this->addSectionForm($form, $section);
    }

    public function preSubmit(FormEvent $event)
    {
        $form = $event->getForm();

        $this->addSectionForm($form);
    }
}