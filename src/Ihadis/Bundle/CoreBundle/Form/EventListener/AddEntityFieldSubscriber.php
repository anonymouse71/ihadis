<?php

namespace Ihadis\Bundle\CoreBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AddEntityFieldSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data->getId()) {
            $this->addHiddenEntityFields($form);
        } else {
            //$this->addChoiceEntityFields($form);
            $this->addHiddenEntityFields($form);
        }
    }

    /**
     * @param $form
     */
    protected function addHiddenEntityFields($form)
    {
        $form->add('book', 'entity_hidden', array(
            'class' => 'IhadisCoreBundle:Book'
        ));

        $form->add('chapter', 'entity_hidden', array(
            'class' => 'IhadisCoreBundle:Chapter'
        ));

        $form->add('section', 'entity_hidden', array(
            'class' => 'IhadisCoreBundle:Section'
        ));
    }

    /**
     * @param $form
     */
    protected function addChoiceEntityFields($form)
    {
        $form->add('book', 'entity', array(
            'class'    => 'IhadisCoreBundle:Book',
            'property' => 'title',
        ));

        $form->add('chapter', 'entity', array(
            'class'    => 'IhadisCoreBundle:Chapter',
            'property' => 'title'
        ));

        $form->add('section', 'entity', array(
            'class'    => 'IhadisCoreBundle:Section',
            'property' => 'title'
        ));
    }
}