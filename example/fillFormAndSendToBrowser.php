<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use MoveElevator\SputnikPdfForm\Collection\PdfFormCollection;
use MoveElevator\SputnikPdfForm\ValueObject\PdfForm;
use MoveElevator\SputnikPdfForm\Writer\PdfFormWriter;

$writer = new PdfFormWriter(
    __DIR__ . '/pdf/',
    '/usr/local/bin/pdftk'
);

$pdfFormCollection = new PdfFormCollection(
    'filled.pdf',
    new PdfForm(
        __DIR__ . '/../tests/Fixtures/Files/form.pdf',
        [
            'name' => 'Wilhelm Wamhoff Gesellschaft mit beschränkter Haftung & Co.' .
                ' Kommanditgesellschaft Wärme- und Kältetechnik, Kundendienst',
        ]
    )
);

$writer->sendPdf($pdfFormCollection);
