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
            ->add('title', null, array(
                'label' => 'Section Name (Bangla)'
            ))
            ->add('preface', 'textarea', array(
                'label' => 'Section Preface (Bangla)',
                'attr'  => array('rows' => 5)
            ))
            ->add('titleEnglish', null, array(
                'label'  => 'Section Name (English)'
            ))
            ->add('prefaceEnglish', 'textarea', array(
                'label'  => 'Section Preface (English)',
                'attr'  => array('rows' => 5)
            ))
            ->add('titleArabic', null, array(
                'label'  => 'Section Name (Arabic)'
            ))
            ->add('prefaceArabic', 'textarea', array(
                'label'  => 'Section Preface (Arabic)',
                'attr'  => array('rows' => 5)
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
