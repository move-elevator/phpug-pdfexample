<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use MoveElevator\SputnikPdfForm\Metadata\SetMetadataInformation;
use MoveElevator\SputnikPdfForm\Metadata\GetMetadataInformation;

$pdfFile = __DIR__ . '/../tests/Fixtures/Files/form.pdf';

$creator = 'sputnik-pdf-form';
$creationDate = 'D:20170101000000+01\'00\'';
$setMetaData = new SetMetadataInformation('/usr/local/bin/pdftk');

$setMetaData->run($pdfFile, 'Creator', $creator);
$setMetaData->run($pdfFile, 'CreationDate', $creationDate);

$getMetaData = new GetMetadataInformation('/usr/local/bin/pdftk');
$actualCreator = $getMetaData->run($pdfFile, 'Creator');
$actualCreationDate = $getMetaData->run($pdfFile, 'CreationDate');

var_dump(
    'Creator: ' . $actualCreator,
    'CreationDate: ' . $actualCreationDate
);
