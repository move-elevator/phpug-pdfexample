<?php

declare(strict_types=1);

namespace MoveElevator\SputnikPdfForm\Tests\Pdf;

use MoveElevator\SputnikPdfForm\Tests\TestCase\PdfTestCase;

class PdfDocumentExampleTest extends PdfTestCase
{
    public function testIfPdfHasExpectedFields(): void
    {
        $pdfPath = dirname(__FILE__) . '/../Fixtures/Files/form.pdf';

        $this->assertPdfFieldsExists(
            [
                'name',
            ],
            $pdfPath
        );
    }
}
