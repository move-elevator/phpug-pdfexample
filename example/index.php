<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use MoveElevator\SputnikPdfForm\Collection\PdfFormCollection;
use MoveElevator\SputnikPdfForm\ValueObject\PdfForm;
use MoveElevator\SputnikPdfForm\Writer\PdfFormWriter;

$writer = new PdfFormWriter(
    __DIR__ . '/',
    '/usr/local/bin/pdftk'
);

$pdfFormCollection = new PdfFormCollection(
    'filled.pdf',
    new PdfForm(
        __DIR__ . '/../tests/Fixtures/Files/card.pdf',
        [
            'title' => "Die PHP Usergroup Dresden \nwünscht frohe Weihnachten!",
            'spruch' => file_get_contents(__DIR__ . '/../tests/Fixtures/Text/xmas.txt'),
        ]
    )
);

var_dump(
    $writer->writePdfFile($pdfFormCollection)
);

header('Location: http://localhost:8053/filled.pdf');
