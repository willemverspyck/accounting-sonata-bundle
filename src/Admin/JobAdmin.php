<?php

declare(strict_types=1);

namespace Spyck\AccountingSonataBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\Form\Type\DatePickerType;
use Spyck\AccountingBundle\Entity\Job;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

#[AutoconfigureTag('sonata.admin', [
    'manager_type' => 'orm',
    'model_class' => Job::class,
    'show_in_dashboard' => false,
])]
final class JobAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->with('Fields')
                ->add('name', null, [
                    'required' => false,
                ])
                ->add('service', null, [
                    'required' => true,
                ])
                ->add('quantity', null, [
                    'required' => true,
                ])
                ->add('amount', MoneyType::class, [
                    'required' => true,
                ])
                ->add('date', DatePickerType::class, [
                    'format' => DateType::HTML5_FORMAT,
                    'required' => true,
                ])
            ->end();
    }
}
