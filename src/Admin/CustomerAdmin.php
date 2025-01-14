<?php

declare(strict_types=1);

namespace Spyck\AccountingSonataBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Spyck\AccountingBundle\Entity\Customer;
use Spyck\SonataExtension\Utility\DateTimeUtility;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('sonata.admin', [
    'group' => 'Accounting',
    'manager_type' => 'orm',
    'model_class' => Customer::class,
    'label' => 'Customer',
])]
final class CustomerAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->with('Fields')
                ->add('name', null, [
                    'required' => true,
                ])
                ->add('code', null, [
                    'required' => false,
                ])
                ->add('contact', null, [
                    'required' => true,
                ])
                ->add('address', null, [
                    'required' => true,
                ])
                ->add('zipcode', null, [
                    'required' => true,
                ])
                ->add('city', null, [
                    'required' => true,
                ])
                ->add('country', null, [
                    'required' => true,
                ])
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('name')
            ->add('code')
            ->add('contact')
            ->add('address')
            ->add('zipcode')
            ->add('city')
            ->add('country');
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('name')
            ->add('code')
            ->add('contact')
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('name')
            ->add('code')
            ->add('contact')
            ->add('address')
            ->add('zipcode')
            ->add('city')
            ->add('country')
            ->add('timestampCreated', null, [
                'format' => DateTimeUtility::FORMAT_DATETIME,
            ])
            ->add('timestampUpdated', null, [
                'format' => DateTimeUtility::FORMAT_DATETIME,
            ]);
    }
}
