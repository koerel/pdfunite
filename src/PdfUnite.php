<?php

namespace Koerel\PdfUnite;

class PdfUnite
{
    private $binary;
    private $output;

    public function __construct($binary = null)
    {
        $this->binary = $binary ?: 'pdfunite';
    }

    public function join(...$files)
    {
        if (count($files) < 2) {
            throw new \Exception("pdfunite requires at least 2 arguments");
        }
        $this->output = array_pop($files);
        $input = implode(' ', $files);
        exec("{$this->binary} {$input} {$this->output}");

        return $this;
    }

    public function output()
    {
        if (null === $this->output) {
            throw new \Exception('Output not found');
        }

        return file_get_contents($this->output);
    }

    public function download()
    {
        if (null === $this->output) {
            throw new \Exception('Output not found');
        }
        $fileInfo = pathinfo($this->output);
        $filename = $fileInfo['filename'] . '.' . strtoupper($fileInfo['extension']);
        header('Content-Type: application/pdf');
        header("Content-Disposition: attachment; filename={$filename}");
        header('Content-Length: ' . filesize($this->output));
        header('Pragma: no-cache');
        readfile($this->output);
    }
}
