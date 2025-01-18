<?php

declare(strict_types=1);

namespace Spyck\AccountingSonataBundle\Controller;

use Spyck\AccountingBundle\Entity\Invoice;
use Spyck\AccountingBundle\Event\DownloadEvent;
use Spyck\AccountingBundle\Service\InvoiceService;
use Spyck\AccountingSonataBundle\Utility\DataUtility;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[AsController]
final class InvoiceController extends AbstractController
{
    /**
     * @throws AccessDeniedException
     * @throws NotFoundHttpException
     */
    public function codeAction(InvoiceService $invoiceService): Response
    {
        $this->admin->checkAccess('edit');

        $invoice = $this->admin->getSubject();

        DataUtility::assert($invoice instanceof Invoice, $this->createNotFoundException('Invoice not found'));

        $invoiceService->patchInvoiceCode($invoice);

        $this->addFlash('sonata_flash_success', 'The invoice has been generated.');

        return $this->redirectToList();
    }

    /**
     * @throws AccessDeniedException
     * @throws NotFoundHttpException
     */
    public function downloadAction(EventDispatcherInterface $eventDispatcher): Response
    {
        $this->admin->checkAccess('edit');

        $invoice = $this->admin->getSubject();

        DataUtility::assert($invoice instanceof Invoice, $this->createNotFoundException('Invoice not found'));

        $downloadEvent = new DownloadEvent($invoice);

        $eventDispatcher->dispatch($downloadEvent);

        $response = $downloadEvent->getResponse();

        if (null === $response) {
            /* @todo: Fallback to HTML generator */
            throw new NotFoundHttpException('Response not found');
        }

        return $response;
    }
}
