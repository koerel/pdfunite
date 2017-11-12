# A PHP wrapper for pdfunite

[![StyleCI](https://styleci.io/repos/110376362/shield?branch=master)](https://styleci.io/repos/110376362)


pdfunite is part of the [poppler](https://poppler.freedesktop.org/) PDF library.
It is a command-line tool use to join PDF files.
This library provides a PHP wrapper around pdfunite.

## Installation

run `composer require koerel/pdfunite`

## Usage

The join method accepts any number of input files, the last parameter is the output file.
```pdf
$unite = new Koerel\PdfUnite\PdfUnite();
$unite->join('file1.pdf', 'file2.pdf', 'output.pdf');
```
If the pdfunite-binary is not in the $PATH you can pass it's path to the constructor.
```pdf
$unite = new Koerel\PdfUnite\PdfUnite('path/to/pdfunite');
$unite->join('file1.pdf', 'file2.pdf', 'output.pdf');
```
To get the result as a string you can chain the output() method
```pdf
$unite = new Koerel\PdfUnite\PdfUnite();
$pdfData = $unite->join('file1.pdf', 'file2.pdf', 'output.pdf')->output();
```
To download the resulting PDF, you can chain the download() method
```pdf
$unite = new Koerel\PdfUnite\PdfUnite();
$unite->join('file1.pdf', 'file2.pdf', 'output.pdf')->download();
```