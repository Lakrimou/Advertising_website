<?php


namespace Svt\BassemBundle\Form\EventListener;


use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Svt\BassemBundle\Entity\Classe;
use Svt\BassemBundle\Entity\Section;
use Svt\BassemBundle\Entity\Module;

class AddModuleFieldSubscriber implements EventSubscriberInterface
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

    private function addModuleForm($form, $classe_id)
    {
        $formOptions = array(
            'class'         => 'SvtBassemBundle:Module',
            'placeholder'   => 'module',
            'label'         => 'module',
            'attr'          => array(
                'class' => 'city_selector',
            ),
            'query_builder' => function (EntityRepository $repository) use ($classe_id) {
                $qb = $repository->createQueryBuilder('module')
                    ->innerJoin('module.classe', 'classe')
                    ->where('classe.id = :classe')
                    ->setParameter('classe', $classe_id)
                ;

                return $qb;
            }
        );

        $form->add($this->propertyPathToModule, EntityType::class, $formOptions);
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $accessor    = PropertyAccess::createPropertyAccessor();

        $module        = $accessor->getValue($data, $this->propertyPathToModule);
        $classe_id = ($module) ? $module->getClasse()->getId() : null;

        $this->addModuleForm($form, $classe_id);
    }

    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        $classe_id = array_key_exists('classe', $data) ? $data['classe'] : null;

        $this->addModuleForm($form, $classe_id);
    }
}