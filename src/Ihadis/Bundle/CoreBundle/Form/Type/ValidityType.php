<?php

namespace Ihadis\Bundle\CoreBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ValidityType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
//            ->add('sortOrder', null, array('label' => 'Position'))
            ->add('color', null, array('label' => 'Text Color'))
            ->add('background', null, array('label' => 'Background Color'))
            ->add('superType', 'entity', array(
                'label'    => 'Main Type',
                'class'    => 'IhadisCoreBundle:Validity',
                'property' => 'title',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('v')
                              ->orderBy('v.sortOrder', 'ASC');
                },
                'attr'     => array('class' => 'input-small')
            ))
            ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ihadis\Bundle\CoreBundle\Entity\Validity'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ihadis_bundle_corebundle_validity';
    }
}
