<?php

declare(strict_types=1);

namespace MoveElevator\SputnikPdfForm\Metadata;

use mikehaertl\pdftk\InfoFields;
use mikehaertl\pdftk\Pdf;

class SetMetadataInformation
{
    public function __construct(
        private readonly string $pdftkPath = '/usr/local/bin/pdftk'
    ) {
    }

    public function run(string $pathToPdf, string $key, string $value): InfoFields|bool
    {
        $pdf = new Pdf($pathToPdf, ['_command' => $this->pdftkPath]);
        $pdf->updateInfo(
            [
                $key => $value,
            ]
        );

        $pdf->saveAs($pathToPdf);

        return (new Pdf($pathToPdf, ['_command' => $this->pdftkPath]))->getData();
    }
}
