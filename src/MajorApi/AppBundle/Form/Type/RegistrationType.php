<?php

namespace MajorApi\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName', 'text')
            ->add('lastName', 'text')
            ->add('email', 'email')
            ->add('password', 'password');
    }

    public function getName()
    {
        return 'registration';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'MajorApi\AppBundle\Entity\Registration',
            'intention' => 'registration'
        ]);
    }

}
