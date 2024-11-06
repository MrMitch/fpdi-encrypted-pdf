<?php

require 'vendor/autoload.php';

use setasign\Fpdi\Tcpdf\Fpdi;
use setasign\FpdiPdfParser\PdfParser\PdfParser;

$pdf = new Fpdi();
$pdf->AddPage();

$directory = __DIR__;
$source = $directory.DIRECTORY_SEPARATOR.'encrypted.pdf';
$destination = $directory.DIRECTORY_SEPARATOR.'generated.pdf';

try {
    echo "Opening file $source\n";
    $pdf->setSourceFileWithParserParams($source, [PdfParser::PARAM_IGNORE_PERMISSIONS => true]);
    echo "Importing page\”";
    $pdf->useTemplate($pdf->ImportPage(1));
    echo "Using template\”";
    $pdf->Output('F', $destination);
    echo "Outputing PDF to $destination\”";
    echo "✅ The PDF has been processed\”";
} catch (\Exception $exception) {
    echo sprintf("%s with code %d : %s\n", get_class($exception), $exception->getCode(), $exception->getMessage());
    echo "❌ The PDF could not be processed\n";
}

