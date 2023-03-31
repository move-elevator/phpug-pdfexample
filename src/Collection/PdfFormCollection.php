<?php

declare(strict_types=1);

namespace MoveElevator\SputnikPdfForm\Collection;

use InvalidArgumentException;
use MoveElevator\SputnikPdfForm\ValueObject\PdfForm;

class PdfFormCollection
{
    private string $targetFileName;

    /**
     * @var array|PdfForm[]
     */
    private array $pdfForms;

    private ?string $fontPath = null;

    public function __construct(
        string $targetFileName,
        PdfForm ...$pdfForms
    ) {
        $this->targetFileName = $targetFileName;
        $this->pdfForms = $pdfForms;
    }

    /**
     * @return PdfForm[]
     */
    public function getPdfForms(): array
    {
        return $this->pdfForms;
    }

    public function addPdfForm(PdfForm $pdfForm): void
    {
        $this->pdfForms[] = $pdfForm;
    }

    public function getTargetFileName(): string
    {
        return $this->targetFileName;
    }

    public function setFontPath(string $fontPath): void
    {
        if (false === is_readable($fontPath)) {
            throw new InvalidArgumentException(
                sprintf('Font file "%s" is not readable.', $fontPath)
            );
        }

        $this->fontPath = $fontPath;
    }

    public function getFontPath(): ?string
    {
        return $this->fontPath;
    }
}
