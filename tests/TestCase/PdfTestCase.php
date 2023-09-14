<?php

declare(strict_types=1);

namespace MoveElevator\SputnikPdfForm\Tests\TestCase;

use mikehaertl\pdftk\Pdf;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

class PdfTestCase extends TestCase
{
    protected string $pathToPdftk = '';

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        if (false === empty(getenv('PDFTK_PATH'))) {
            $this->pathToPdftk = getenv('PDFTK_PATH');
        }

        if (true === empty($this->pathToPdftk)) {
            $this->markTestSkipped('PDFTK_PATH is not set');
        }
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
