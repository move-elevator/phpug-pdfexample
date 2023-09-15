<?php

declare(strict_types=1);

namespace MoveElevator\SputnikPdfForm\Tests\TestCase;

use mikehaertl\pdftk\Pdf;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

class PdfTestCase extends TestCase
{
    protected string $pathToPdftk = '';

    protected function setUp(?string $name = null, array $data = [], string $dataName = ''): void
    {
        $pthToPdftk = exec('which pdftk');

        if (true === empty($pthToPdftk)) {
            $this->markTestSkipped('PDFTK_PATH is not set');
        }

        $this->pathToPdftk = $pthToPdftk;
    }

    public function assertPdfFieldsExists(array $expectedFields, string $actualPdfPath)
    {
        $this->assertFileExists($actualPdfPath);

        $pdf = new Pdf($actualPdfPath, ['_command' => $this->pathToPdftk]);
        $actualFieldsCollection = $pdf->getDataFields()->getArrayCopy();

        $actualFields = [];

        foreach ($actualFieldsCollection as $actualField) {
            $actualFields[] = $actualField['FieldName'];
        }

        foreach ($expectedFields as $expectedField) {
            try {
                $this->assertContains($expectedField, $actualFields);
            } catch (ExpectationFailedException $exception) {
                throw new ExpectationFailedException(
                    sprintf(
                        'Expected field "%s" not found in PDF "%s"',
                        $expectedField,
                        $actualPdfPath
                    ),
                    null,
                    $exception
                );
            }
        }
    }
}
