<?php

declare(strict_types=1);

namespace MoveElevator\SputnikPdfForm\Metadata;

use mikehaertl\pdftk\InfoFields;
use mikehaertl\pdftk\Pdf;
use RuntimeException;

class GetMetadataInformation
{
    public function __construct(
        private readonly string $pdftkPath = '/usr/local/bin/pdftk'
    ) {
    }

    public function run(string $pathToPdf, string $key): ?string
    {
        $pdf = new Pdf($pathToPdf, ['_command' => $this->pdftkPath]);
        $metaData = $pdf->getData();

        if (false === $metaData instanceof InfoFields) {
            throw new RuntimeException('Could not get metadata information', 1681805721);
        }

        if (false === is_array($metaData->getArrayCopy()['Info'])) {
            return null;
        }

        if (false === is_scalar($metaData->getArrayCopy()['Info'][$key])) {
            return null;
        }

        return (string) $metaData->getArrayCopy()['Info'][$key];
    }
}
