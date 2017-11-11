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
        $command = "{$this->binary} {$input} {$this->output}";
        $descriptors = [
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];
        $process = proc_open($command, $descriptors, $pipes);
        if (!is_resource($process)) {
            throw new \Exception("Could not run pdfunite");
        }
        $error = stream_get_contents($pipes[2]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        $exitCode = proc_close($process);
        if ($exitCode !== 0) {
            throw new \Exception($error);
        }


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
