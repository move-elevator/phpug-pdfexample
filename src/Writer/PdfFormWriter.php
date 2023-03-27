<?php

declare(strict_types=1);

namespace MoveElevator\SputnikPdfForm\Writer;

use mikehaertl\pdftk\Pdf;
use MoveElevator\SputnikPdfForm\Formatter\FieldValuesFormatter;

class PdfFormWriter
{
    public function __construct(
        private readonly string $pdfTargetFolder,
        private readonly string $pdftkPath = '/usr/local/bin/pdftk'
    ) {
    }

    public function writePdfFile(string $pdfSourcePath, string $targetFileName, array $fieldValues): string
    {
        $this->preparePdf($pdfSourcePath, $fieldValues)->saveAs(
            sprintf('%s%s', $this->pdfTargetFolder, $targetFileName)
        );

        return sprintf('%s%s', $this->pdfTargetFolder, $targetFileName);
    }

    public function sendPdf(string $pdfSourcePath, string $targetFileName, array $fieldValues): bool
    {
        return $this->preparePdf($pdfSourcePath, $fieldValues)
            ->send(
                $targetFileName,
                false,
                [
                    'Cache-Control' => 'no-cache',
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="' . $targetFileName . '"',
                ]
            );
    }

    private function preparePdf(string $pdfSourcePath, array $fieldValues): Pdf
    {
        $pdf = new Pdf(
            $pdfSourcePath,
            [
                '_command' => $this->pdftkPath,
            ]
        );

        return $pdf
            ->fillForm(FieldValuesFormatter::format($fieldValues))
            ->flatten()
            ->needAppearances()
            ->compress();
    }
}
