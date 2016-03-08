<?php

namespace Ihadis\Bundle\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ChapterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, array(
                'label' => 'Chapter Name (Bangla)')
            )
            ->add('titleEnglish', null, array(
                'label'  => 'Chapter Name (English)',
                'required' => false)
            )
            ->add('titleArabic', null, array(
                'label'  => 'Chapter Name (Arabic)',
                'required' => false)
            )
            ->add('number', null, array(
                'label'  => 'Number'
            ))
            ->add('preface', null, array(
                'label'  => 'Preface'
            ))
            ->add('range', null, array(
                'label'  => 'Range'
            ))
            ->add('book', 'entity', array(
                'label'    => 'Book',
                'class'    => 'IhadisCoreBundle:Book',
                'property' => 'title')
            )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ihadis\Bundle\CoreBundle\Entity\Chapter',
        ));
    }

    public function getName()
    {
        return 'ihadis_chapter';
    }
}
