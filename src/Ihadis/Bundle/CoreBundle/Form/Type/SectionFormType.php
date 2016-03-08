<?php

namespace Ihadis\Bundle\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SectionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('book', 'entity', array(
                     'label'    => 'Book',
                     'class'    => 'IhadisCoreBundle:Book',
                     'property' => 'title'))
            ->add('chapter', 'entity', array(
                     'label'    => 'Chapter',
                     'class'    => 'IhadisCoreBundle:Chapter',
                     'property' => 'title')
            )
            ->add('range', null, array(
                'label'  => 'Range'
            ))
            ->add('number', null, array(
                'label' => 'Section Number (Bangla)'
            ))
            ->add('title', null, array(
                'label' => 'Section Name (Bangla)'
            ))
            ->add('preface', 'textarea', array(
                'label' => 'Section Preface (Bangla)',
                'required' => false,
                'attr'  => array('rows' => 5)
            ))
            ->add('numberEnglish', null, array(
                'label' => 'Section Number (English)',
                'required' => false
            ))
            ->add('titleEnglish', null, array(
                'label'  => 'Section Name (English)',
                'required' => false
            ))
            ->add('prefaceEnglish', 'textarea', array(
                'label'  => 'Section Preface (English)',
                'required' => false,
                'attr'  => array('rows' => 5)
            ))
            ->add('numberArabic', null, array(
                'label' => 'Section Number (Arabic)',
                'required' => false,
            ))
            ->add('titleArabic', null, array(
                'label'  => 'Section Name (Arabic)',
                'required' => false,
            ))
            ->add('prefaceArabic', 'textarea', array(
                'label'  => 'Section Preface (Arabic)',
                'required' => false,
                'attr'  => array('rows' => 5)
            ))
            ->add('sortOrder', null, array(
                'label' => 'Sorting Order'
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ihadis\Bundle\CoreBundle\Entity\Section',
        ));
    }

    public function getName()
    {
        return 'ihadis_section';
    }
}
