<?php

use Koerel\PdfUnite\PdfUnite;
use PHPUnit\Framework\TestCase;

final class PdfUniteTest extends TestCase
{
    private $file1 = './tests/assets/file1.pdf';
    private $file2 = './tests/assets/file2.pdf';
    private $output = './tests/assets/output.pdf';

    public function testItCanBeInstanciated()
    {
        $unite = new PdfUnite();
        $this->assertInstanceOf(PdfUnite::class, $unite);
    }

    public function testItCanJoinTwoFiles()
    {
        $unite = new PdfUnite();
        $unite->join($this->file1, $this->file2, $this->output);
        $this->assertFileExists($this->output);
        unlink($this->output);
    }

    public function testItCanReturnTheFileContent()
    {
        $unite = new PdfUnite();
        $content = $unite->join($this->file1, $this->file2, $this->output)->output();
        $this->assertInternalType('string', $content);
        unlink($this->output);
    }
}
