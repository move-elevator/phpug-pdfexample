<?php

declare(strict_types=1);

namespace MoveElevator\SputnikPdfForm\Metadata;

use mikehaertl\pdftk\InfoFields;
use mikehaertl\pdftk\Pdf;

class GetMetadataInformation
{
    public function __construct(
        private readonly string $pdftkPath = '/usr/local/bin/pdftk'
    ) {
    }

    public function run(string $pathToPdf, string $key): string
    {
        $pdf = new Pdf($pathToPdf, ['_command' => $this->pdftkPath]);
        $updateMetaSet = $pdf->getData($utf8);

        if (false === $updateMetaSet instanceof InfoFields) {
            throw new RuntimeException('Could not get metadata information', 1681805721);
        }

        return (string)$updateMetaSet->filter(
            static function ($metaValue, $metaKey) use ($key) {
                return $metaKey === $key;
            }
        )->first();
    }
}
