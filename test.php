<?php

require 'vendor/autoload.php';

use setasign\Fpdi\Tcpdf\Fpdi;
use setasign\FpdiPdfParser\PdfParser\PdfParser;

$pdf = new Fpdi();
$pdf->AddPage();

$directory = __DIR__;
$source = $directory.DIRECTORY_SEPARATOR.'encrypted.pdf';
$destination = $directory.DIRECTORY_SEPARATOR.'generated.pdf';

echo 'PHP_VERSION: ' . PHP_VERSION . "\n";
echo 'OPENSSL_VERSION_NUMBER: '.OPENSSL_VERSION_NUMBER."\n";
echo 'OPENSSL_VERSION_TEXT: '.OPENSSL_VERSION_TEXT."\n";
echo "\n";

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
    $prev = $exception->getPrevious();
    assert($prev !== null);

    $class = new ReflectionClass(get_class($prev));
    $constants = $class->getConstants();
    $constantName = null;
    foreach ($constants as $name => $value) {
        if ($value === $prev->getCode()) {
            $constantName = $name;
            break;
        }
    }

    echo sprintf("PREVIOUS: %s with code %d (%s) : %s\n", $class->name, $prev->getCode(), $constantName ?? 'unknown', $prev->getMessage());
    echo "❌ The PDF could not be processed\n";
}

