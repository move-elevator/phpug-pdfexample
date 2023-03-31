<?php

declare(strict_types=1);

namespace MoveElevator\SputnikPdfForm\ValueObject;

class PdfForm
{
    /**
     * @param string $pdfSourcePath
     * @param array<string, mixed>  $fieldValues
     */
    public function __construct(
        private readonly string $pdfSourcePath,
        private readonly array $fieldValues
    ) {
    }

    public function getPdfSourcePath(): string
    {
        return $this->pdfSourcePath;
    }

    /**
     * @return array<string, mixed>
     */
    public function getFieldValues(): array
    {
        return $this->fieldValues;
    }
}
