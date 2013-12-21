<?php

namespace Ihadis\Bundle\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName', 'text', array(
            'required' => true
        ))->add('lastName', 'text', array(
            'required' => true
        ))->add('username', 'text', array(
            'required' => true
        ))->add('email', 'text', array(
            'required' => true
        ))->add('password', 'password', array(
            'required' => true
        ))->add('roles', 'choice', array(
            'required' => true,
            'choices'  => array('ROLE_SUPER_ADMIN' => 'Super Admin', 'ROLE_ADMIN' => 'Admin'),
            'multiple' => true
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ihadis\Bundle\CoreBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'user';
    }
}