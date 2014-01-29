<?php

namespace MajorApi\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ApplicationCreationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text')
            ->add('username', 'text');
    }

    public function getName()
    {
        return 'application';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'MajorApi\AppBundle\Entity\Application',
            'intention' => 'application',
            'validation_groups' => ['create']
        ]);
    }

}
