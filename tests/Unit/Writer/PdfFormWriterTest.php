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
                dirname(__FILE__) . '/../../Fixtures/Files/form.pdf',
                [
                    'name' => 'Wilhelm Wamhoff Gesellschaft mit beschränkter Haftung & Co.' .
                        ' Kommanditgesellschaft Wärme- und Kältetechnik, Kundendienst',
                ]
            ),
            new PdfForm(
                dirname(__FILE__) . '/../../Fixtures/Files/form2.pdf',
                [
                    'name' => 'ÄÜÖ äüö мирано čárka',
                ]
            )
        );

        $pdfFormCollection->setFontPath(dirname(__FILE__) . '/../../Fixtures/Fonts/DejaVuSans.ttf');

        $pdfFormWriter = new PdfFormWriter(
            dirname(__FILE__) . '/../../Fixtures/Files/',
            $this->pathToPdftk
        );

        $pdfFormWriter->writePdfFile($pdfFormCollection);

        $this->assertFileExists(dirname(__FILE__) . '/../../Fixtures/Files/filled.pdf');
    }

    /**
     * @runInSeparateProcess
     */
    public function testToSendFile(): void
    {
        $pdfFormCollection = new PdfFormCollection(
            'filled.pdf',
            new PdfForm(
                dirname(__FILE__) . '/../../Fixtures/Files/form.pdf',
                [
                    'name' => 'Wilhelm Wamhoff Gesellschaft mit beschränkter Haftung & Co.' .
                        ' Kommanditgesellschaft Wärme- und Kältetechnik, Kundendienst',
                ]
            )
        );

        $pdfFormWriter = new PdfFormWriter(
            dirname(__FILE__) .  '/../../Fixtures/Files/',
            $this->pathToPdftk
        );

        $pdfFormWriter->sendPdf($pdfFormCollection);

        $this->assertContains('Cache-Control: no-cache', xdebug_get_headers());
        $this->assertContains('Content-Type: application/pdf', xdebug_get_headers());
        $this->assertContains('Content-Disposition: attachment; filename="filled.pdf"', xdebug_get_headers());
    }

    public function testToSaveFileWithError(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionCode(1694815132);

        $pdfFormCollection = new PdfFormCollection(
            'filled.pdf',
            new PdfForm(
                dirname(__FILE__) . '/../../Fixtures/Files/form_invalid.pdf',
                [
                    'name' => 'Wilhelm Wamhoff Gesellschaft mit beschränkter Haftung & Co.' .
                        ' Kommanditgesellschaft Wärme- und Kältetechnik, Kundendienst',
                ]
            ),
            new PdfForm(
                dirname(__FILE__) . '/../../Fixtures/Files/form2.pdf',
                [
                    'name' => 'ÄÜÖ äüö мирано čárka',
                ]
            )
        );

        $pdfFormWriter = new PdfFormWriter(
            dirname(__FILE__) . '/../../Fixtures/Files/',
            $this->pathToPdftk
        );

        $pdfFormWriter->writePdfFile($pdfFormCollection);

        $this->assertFileExists(dirname(__FILE__) . '/../../Fixtures/Files/filled.pdf');
    }

    /**
     * @runInSeparateProcess
     */
    public function testToSendFileWithError(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionCode(1694815132);

        $pdfFormCollection = new PdfFormCollection(
            'filled.pdf',
            new PdfForm(
                dirname(__FILE__) . '/../../Fixtures/Files/form_invalid.pdf',
                [
                    'name' => 'Wilhelm Wamhoff Gesellschaft mit beschränkter Haftung & Co.' .
                        ' Kommanditgesellschaft Wärme- und Kältetechnik, Kundendienst',
                ]
            )
        );

        $pdfFormWriter = new PdfFormWriter(
            dirname(__FILE__) .  '/../../Fixtures/Files/',
            $this->pathToPdftk
        );

        $pdfFormWriter->sendPdf($pdfFormCollection);

        $this->assertContains('Cache-Control: no-cache', xdebug_get_headers());
        $this->assertContains('Content-Type: application/pdf', xdebug_get_headers());
        $this->assertContains('Content-Disposition: attachment; filename="filled.pdf"', xdebug_get_headers());
    }

    protected function setUp(): void
    {
        $pthToPdftk = exec('which pdftk');

        if (true === empty($pthToPdftk)) {
            $this->markTestSkipped('PDFTK_PATH is not set');
        }

        $this->pathToPdftk = $pthToPdftk;
    }

    protected function tearDown(): void
    {
        if (file_exists(dirname(__FILE__) .  '/../../Fixtures/Files/filled.pdf')) {
            unlink(dirname(__FILE__) .  '/../../Fixtures/Files/filled.pdf');
        }
    }
}
