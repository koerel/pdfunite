<?php

namespace Koerel\Pdfunite;

class Pdfunite
{
    private $binary;
    private $output;

    public function __construct(array $options = [])
    {
        $this->binary = $options['binary'] ?? 'pdfunite';
    }

    public function join(...$files)
    {
        if (count($files) < 2) {
            throw new Exception("pdfunite requires at least 2 arguments");
        }
        $this->output = array_pop($files);
        $input = implode(' ', $files);
        exec("{$this->binary} {$input} {$this->output}");

        return $this;
    }

    public function output()
    {
        if (null === $this->output) {
            throw new Exception('Please run join() first');
        }

        return file_get_contents($this->output);
    }

    public function download()
    {
        if (null === $this->output) {
            throw new Exception('Please run join() first');
        }
        header('Content-Type: application/pdf');
        header("Content-Disposition: attachment; filename={$this->output}");
        header('Pragma: no-cache');

        return file_get_contents($this->output);
    }
}
