<?php

namespace MajorApi\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AccountBillingType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('cardNumber', 'text')
            ->add('expirationMonth', 'text')
            ->add('expirationYear', 'text')
            ->add('cvc', 'text');
    }

    public function getName()
    {
        return 'accountBilling';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'MajorApi\AppBundle\Entity\AccountBilling',
            'intention' => 'accountBilling',
            'validation_groups' => ['billing']
        ]);
    }

}
