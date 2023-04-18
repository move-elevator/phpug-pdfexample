<?php

declare(strict_types = 1);

namespace MoveElevator\SputnikPdfForm\Metadata;

use mikehaertl\pdftk\InfoFields;
use RuntimeException;
use mikehaertl\pdftk\Pdf;

class SetMetadataInformtion
{
    public function __construct(
        private readonly string $pdftkPath = '/usr/local/bin/pdftk'
    ) {
    }

    public function run(string $pathToPdf, string $key, string $value, $utf8 = true): InfoFields
    {
        $pdf = new Pdf($pathToPdf, ['_command' => $this->pdftkPath]);
        $pdf->updateInfo(
            [
                $key => $value,
            ],
            $utf8
        );
        $pdf->saveAs($pathToPdf);

        if(false === empty($pdf->getError())) {
            throw new RuntimeException($pdf->getError(), 1681805720);
        }

        $updateMetaSet = $pdf->getData($utf8);

        if (false === $updateMetaSet instanceof InfoFields) {
            throw new RuntimeException('Could not get metadata information', 1681805721);
        }

        return $updateMetaSet;
    }
}
