<?php

declare(strict_types=1);

namespace Spyck\AccountingSonataBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Spyck\AccountingBundle\Entity\Service;
use Spyck\SonataExtension\Utility\DateTimeUtility;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;

#[AutoconfigureTag('sonata.admin', [
    'group' => 'Accounting',
    'manager_type' => 'orm',
    'model_class' => Service::class,
    'label' => 'Service',
])]
final class ServiceAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->with('Fields')
                ->add('name', null, [
                    'required' => true,
                ])
                ->add('amount', MoneyType::class, [
                    'required' => false,
                ])
                ->add('tax')
                ->add('taxRate', PercentType::class, [
                    'required' => true,
                ])
                ->add('active')
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('name')
            ->add('amount')
            ->add('tax')
            ->add('taxRate')
            ->add('active');
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('name')
            ->add('amount', FieldDescriptionInterface::TYPE_CURRENCY)
            ->add('tax')
            ->add('taxRate', FieldDescriptionInterface::TYPE_PERCENT)
            ->add('active')
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
            ->add('amount', FieldDescriptionInterface::TYPE_CURRENCY)
            ->add('tax')
            ->add('taxRate', FieldDescriptionInterface::TYPE_PERCENT)
            ->add('active')
            ->add('timestampCreated', null, [
                'format' => DateTimeUtility::FORMAT_DATETIME,
            ])
            ->add('timestampUpdated', null, [
                'format' => DateTimeUtility::FORMAT_DATETIME,
            ]);
    }
}
