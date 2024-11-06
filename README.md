This is a reproducer repository to help debug a case where an encrypted PDF cannot be processed with FPDI despite using
`$pdf->setSourceFileWithParserParams('encrypted.pdf', [PdfParser::PARAM_IGNORE_PERMISSIONS => true])`.

The PDF is [included in the repository](encrypted.pdf) and can be opened in any PDF viewer or any browser. It can also
be processed on the demo form included in [Setasign's website](https://www.setasign.com/products/fpdi-pdf-parser/details/)
for FPDI's PDF parser.

However, the code included in this repo produces an error when trying to process the same file. You can launch the
test file with `php -f test.php`.
