<?php

namespace Ihadis\Bundle\CoreBundle\Form\Type;

use Ihadis\Bundle\CoreBundle\Entity\Hadith;
use Ihadis\Bundle\CoreBundle\Form\EventListener\AddEntityFieldSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HadithFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numberPrimary', null, array(
                'label'  => 'Intl. Hadith Number',
                'required' => true,
                'attr'   => array('class' => 'input-small')
            ))
            ->add('numberSecondary', null, array(
                'label'  => 'Bangla Hadith Number',
                'required' => true,
                'attr'   => array('class' => 'input-small')
            ))
            ->add('scholarReviewed', 'choice', array(
                'label'   => 'Scholar Reviewed',
                'choices' => array(0 => 'No', 1 => 'Yes'),
                'attr'   => array('class' => 'input-small')
            ))
            ->add('crossChecked', 'choice', array(
                'label'   => 'Cross Checked',
                'choices' => array(0 => 'No', 1 => 'Yes'),
                'attr'   => array('class' => 'input-small')
            ))
            ->add('validity', 'choice', array(
                'label'  => 'Validity',
                'choices' => array(
                    Hadith::VALIDITY_NONE  => 'N/A',
                    Hadith::VALIDITY_MAUDU => "Maudu'",
                    Hadith::VALIDITY_DAIF  => "Da'if",
                    Hadith::VALIDITY_HASAN => "Hasan",
                    Hadith::VALIDITY_SAHIH => "Sahih"
                ),
                'attr'   => array('class' => 'input-small')
            ))
            ->add('narrator', 'text', array(
                'label'  => 'Hadith Narrator',
                'required' => false
            ))
            ->add('body', 'textarea', array(
                'label' => 'Hadith Text',
                'required' => true,
                'attr'  => array('rows' => 5)
            ))
            ->add('reference', 'textarea', array(
                'label' => 'Reference',
                'required' => false,
                'attr'  => array('rows' => 2)
            ))
            ->add('note', 'textarea', array(
                'label' => 'Note',
                'required' => false,
                'attr'  => array('rows' => 3)
            ))
            ->add('explanation', 'textarea', array(
                'label' => 'Explanation',
                'required' => false,
                'attr'  => array('rows' => 3)
            ))
            ->add('narratorArabic', 'text', array(
                'label'  => 'Hadith Narrator',
                'required' => false
            ))
            ->add('bodyArabic', 'textarea', array(
                'label' => 'Hadith Text',
                'required' => true,
                'attr'  => array('rows' => 5)
            ))
            ->add('referenceArabic', 'textarea', array(
                'label' => 'Reference',
                'required' => false,
                'attr'  => array('rows' => 2)
            ))
            ->add('narratorEnglish', 'text', array(
                'label'  => 'Hadith Narrator',
                'required' => false,
            ))
            ->add('bodyEnglish', 'textarea', array(
                'label' => 'Hadith Text',
                'required' => true,
                'attr'  => array('rows' => 5)
            ))
            ->add('referenceEnglish', 'textarea', array(
                'label' => 'Reference',
                'required' => false,
                'attr'  => array('rows' => 2)
            ))
        ;

        $builder->addEventSubscriber(new AddEntityFieldSubscriber());
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ihadis\Bundle\CoreBundle\Entity\Hadith',
        ));
    }

    public function getName()
    {
        return 'ihadis_hadith';
    }
}