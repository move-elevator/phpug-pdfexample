<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use MoveElevator\SputnikPdfForm\Writer\PdfFormWriter;

$writer = new PdfFormWriter(
    __DIR__ . '/',
    '/usr/local/bin/pdftk'
);

var_dump(
    $writer->writePdfFile(
        __DIR__ . '/../tests/Fixtures/Files/form.pdf',
        'filled.pdf',
        [
            'name' => 'Wilhelm Wamhoff Gesellschaft mit beschränkter Haftung & Co. Kommanditgesellschaft Wärme- und Kältetechnik, Kundendienst',
        ]
    )
);
