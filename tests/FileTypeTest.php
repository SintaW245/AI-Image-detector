<?php

use PHPUnit\Framework\TestCase;

class FileAuditTest extends TestCase
{
    private array $targets;

    protected function setUp(): void
    {
        $this->targets = [
            realpath(__DIR__ . '/../index.php')
        ];
    }

    // TEST CASE 1 //
    public function testTargetFilesAccessible()
    {
        foreach ($this->targets as $path) {
            $this->assertTrue(is_file($path));
        }
    }

    // TEST CASE 2 //
    public function testPhpOpeningTagPresent()
    {
        foreach ($this->targets as $path) {
            if ($this->ext($path) === 'php') {
                $content = file_get_contents($path);
                $this->assertTrue(strpos($content, '<?php') !== false);
            }
        }
    }

    // TEST CASE 3 //
    public function testContainsHtmlElements()
    {
        foreach ($this->targets as $path) {
            if ($this->ext($path) === 'php') {
                $html = strtolower(file_get_contents($path));
                $this->assertTrue(
                    preg_match('/<(html|body|main|div|section)/', $html) > 0
                );
            }
        }
    }

    // TEST CASE 4 //
    public function testFileSizeReasonable()
    {
        foreach ($this->targets as $path) {
            if ($this->ext($path) === 'php') {
                $this->assertTrue(filesize($path) > 20);
            }
        }
    }

    // TEST CASE 5 //
    public function testHtmlDocumentClosed()
    {
        foreach ($this->targets as $path) {
            if ($this->ext($path) === 'php') {
                $html = strtolower(file_get_contents($path));
                $this->assertTrue(str_contains($html, '</html>'));
            }
        }
    }

    private function ext(string $file): string
    {
        return pathinfo($file, PATHINFO_EXTENSION);
    }
}
