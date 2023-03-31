<?php

declare(strict_types=1);

namespace MoveElevator\SputnikPdfForm\Writer;

use mikehaertl\pdftk\Pdf;
use MoveElevator\SputnikPdfForm\Collection\PdfFormCollection;
use MoveElevator\SputnikPdfForm\Formatter\FieldValuesFormatter;

class PdfFormWriter
{
    public function __construct(
        private readonly string $pdfTargetFolder,
        private readonly string $pdftkPath = '/usr/local/bin/pdftk'
    ) {
    }

    public function writePdfFile(PdfFormCollection $pdfFormCollection): string
    {
        $this->preparePdf($pdfFormCollection)
            ->saveAs(sprintf('%s%s', $this->pdfTargetFolder, $pdfFormCollection->getTargetFileName()));

        return sprintf('%s%s', $this->pdfTargetFolder, $pdfFormCollection->getTargetFileName());
    }

    public function sendPdf(PdfFormCollection $pdfFormCollection): bool
    {
        return $this->preparePdf($pdfFormCollection)
            ->send(
                $pdfFormCollection->getTargetFileName(),
                false,
                [
                    'Cache-Control' => 'no-cache',
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => sprintf(
                        'attachment; filename="%s"',
                        $pdfFormCollection->getTargetFileName()
                    ),
                ]
            );
    }

    private function preparePdf(PdfFormCollection $pdfFormCollection): Pdf
    {
        $pdfCollection = new Pdf(null, ['_command' => $this->pdftkPath]);

        foreach ($pdfFormCollection->getPdfForms() as $pdfForm) {
            $pdfDocument = new Pdf($pdfForm->getPdfSourcePath(), ['_command' => $this->pdftkPath]);

            $pdfDocument
                ->fillForm(FieldValuesFormatter::format($pdfForm->getFieldValues()))
                ->flatten()
                ->needAppearances()
                ->compress();

            if (null !== $pdfFormCollection->getFontPath()) {
                $pdfDocument->replacementFont($pdfFormCollection->getFontPath());
            }

            $pdfCollection->addFile($pdfDocument);
        }

        if (null !== $pdfFormCollection->getFontPath()) {
            $pdfCollection->replacementFont($pdfFormCollection->getFontPath());
        }

        return $pdfCollection
            ->flatten()
            ->needAppearances()
            ->compress();
    }
}
