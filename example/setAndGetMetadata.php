<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use MoveElevator\SputnikPdfForm\Metadata\SetMetadataInformtion;

$pdfFile = __DIR__ . '/../tests/Fixtures/Files/form.pdf';

$contractBasicDate = 1681806713;
$setMetaData = new SetMetadataInformtion('/usr/local/bin/pdftk');

$setMetaData->run($pdfFile, 'contractBasicDate', (string)$contractBasicDate);

$getMetaData = new GetMetadataInformtion('/usr/local/bin/pdftk');
$actual = $getMetaData->run($pdfFile, 'contractBasicDate');

var_dump(
    'Expected: ' . $contractBasicDate,
    'Actual: ' . $actual
);
