<?php

declare(strict_types=1);

namespace Spyck\AccountingSonataBundle\Controller;

use Spyck\AccountingBundle\Entity\Invoice;
use Spyck\AccountingBundle\Service\InvoiceService;
use Spyck\AccountingSonataBundle\Utility\DataUtility;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[AsController]
final class InvoiceController extends AbstractController
{
    /**
     * @throws AccessDeniedException If access is not granted
     * @throws RuntimeException      If no editable field is defined
     */
    public function codeAction(InvoiceService $invoiceService, Request $request): Response
    {
        $this->admin->checkAccess('edit');

        $invoice = $this->admin->getSubject();

        DataUtility::assert($invoice instanceof Invoice, $this->createNotFoundException('Invoice not found'));

        $invoiceService->patchInvoiceCode($invoice);

        $this->addFlash('sonata_flash_success', 'The invoice has been generated.');

        return $this->redirectToList();
    }
}
