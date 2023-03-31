<?php

declare(strict_types=1);

namespace MoveElevator\SputnikPdfForm\Tests\Unit\Writer;

use MoveElevator\SputnikPdfForm\Collection\PdfFormCollection;
use MoveElevator\SputnikPdfForm\ValueObject\PdfForm;
use MoveElevator\SputnikPdfForm\Writer\PdfFormWriter;
use PHPUnit\Framework\TestCase;

class PdfFormWriterTest extends TestCase
{
    private string $pathToPdftk = '';

    public function testToSaveFile(): void
    {
        $pdfFormCollection = new PdfFormCollection(
            'filled.pdf',
            new PdfForm(
                __DIR__ . '/../../Fixtures/Files/form.pdf',
                [
                    'name' => 'Wilhelm Wamhoff Gesellschaft mit beschränkter Haftung & Co.' .
                        ' Kommanditgesellschaft Wärme- und Kältetechnik, Kundendienst',
                ]
            ),
            new PdfForm(
                __DIR__ . '/../../Fixtures/Files/form2.pdf',
                [
                    'name' => 'ÄÜÖ äüö мирано čárka',
                ]
            )
        );

        $pdfFormCollection->setFontPath(__DIR__ . '/../../Fixtures/Fonts/DejaVuSans.ttf');

        $pdfFormWriter = new PdfFormWriter(
            __DIR__ . '/../../Fixtures/Files/',
            $this->pathToPdftk
        );

        $pdfFormWriter->writePdfFile($pdfFormCollection);

        $this->assertFileExists(__DIR__ . '/../../Fixtures/Files/filled.pdf');
    }

    /**
     * @runInSeparateProcess
     */
    public function testToSendFile(): void
    {
        $pdfFormCollection = new PdfFormCollection(
            'filled.pdf',
            new PdfForm(
                __DIR__ . '/../../Fixtures/Files/form.pdf',
                [
                    'name' => 'Wilhelm Wamhoff Gesellschaft mit beschränkter Haftung & Co.' .
                        ' Kommanditgesellschaft Wärme- und Kältetechnik, Kundendienst',
                ]
            )
        );

        $pdfFormWriter = new PdfFormWriter(
            __DIR__ . '/../../Fixtures/Files/',
            $this->pathToPdftk
        );

        $pdfFormWriter->sendPdf($pdfFormCollection);
        
        $this->assertContains('Cache-Control: no-cache', xdebug_get_headers());
        $this->assertContains('Content-Type: application/pdf', xdebug_get_headers());
        $this->assertContains('Content-Disposition: attachment; filename="filled.pdf"', xdebug_get_headers());
    }

    protected function setUp(): void
    {
        $pathToPdftk = shell_exec(sprintf("which %s", escapeshellarg('pdftk')));
        if (true === empty($pathToPdftk)) {
            $this->markTestSkipped('Pdftk is not installed.');
        }

        $this->pathToPdftk = trim($pathToPdftk);
    }

    protected function tearDown(): void
    {
        if (file_exists(__DIR__ . '/../../Fixtures/Files/filled.pdf')) {
            unlink(__DIR__ . '/../../Fixtures/Files/filled.pdf');
        }
    }
}