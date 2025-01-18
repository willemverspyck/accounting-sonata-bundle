<?php

declare(strict_types=1);

namespace Spyck\AccountingSonataBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Filter\ModelFilter;
use Sonata\Form\Type\CollectionType;
use Sonata\Form\Type\DatePickerType;
use Spyck\AccountingBundle\Entity\Invoice;
use Spyck\AccountingSonataBundle\Controller\InvoiceController;
use Spyck\SonataExtension\Filter\DateRangeFilter;
use Spyck\SonataExtension\Utility\DateTimeUtility;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\Form\Extension\Core\Type\DateType;

#[AutoconfigureTag('sonata.admin', [
    'controller' => InvoiceController::class,
    'group' => 'Accounting',
    'manager_type' => 'orm',
    'model_class' => Invoice::class,
    'label' => 'Invoice',
])]
final class InvoiceAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->with('Fields')
                ->add('customer', null, [
                    'required' => true,
                ])
                ->add('name', null, [
                    'required' => false,
                ])
                ->add('jobs', CollectionType::class, [], [
                    'edit' => 'inline',
                    'inline' => 'table',
                ])
                ->add('timestampPayment', DatePickerType::class, [
                    'format' => DateType::HTML5_FORMAT,
                    'required' => false,
                ])
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('customer')
            ->add('name')
            ->add('code')
            ->add('amount')
            ->add('timestamp', DateRangeFilter::class)
            ->add('timestampPayment', DateRangeFilter::class);
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('customer')
            ->add('name')
            ->add('code')
            ->add('amount', FieldDescriptionInterface::TYPE_CURRENCY)
            ->add('amountTax', FieldDescriptionInterface::TYPE_CURRENCY)
            ->add('timestamp', null, [
                'format' => DateTimeUtility::FORMAT_DATETIME,
            ])
            ->add('timestampPayment', null, [
                'format' => DateTimeUtility::FORMAT_DATE,
            ])
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                    'code' => [
                        'template' => '@SpyckAccountingSonata/invoice/list_action_code.html.twig',
                    ],
                    'download' => [
                        'template' => '@SpyckAccountingSonata/invoice/list_action_download.html.twig',
                    ],
                ],
            ]);
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('customer')
            ->add('name')
            ->add('code')
            ->add('jobs')
            ->add('amount', FieldDescriptionInterface::TYPE_CURRENCY)
            ->add('amountTax', FieldDescriptionInterface::TYPE_CURRENCY)
            ->add('timestamp', null, [
                'format' => DateTimeUtility::FORMAT_DATETIME,
            ])
            ->add('timestampPayment', null, [
                'format' => DateTimeUtility::FORMAT_DATE,
            ])
            ->add('timestampCreated', null, [
                'format' => DateTimeUtility::FORMAT_DATETIME,
            ])
            ->add('timestampUpdated', null, [
                'format' => DateTimeUtility::FORMAT_DATETIME,
            ]);
    }

    protected function getAddRoutes(): iterable
    {
        yield 'code';
        yield 'download';
    }
}
