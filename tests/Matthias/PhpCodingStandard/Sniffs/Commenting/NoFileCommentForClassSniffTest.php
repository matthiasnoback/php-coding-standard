<?php

class NoFileCommentForClassSniffTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider fixturesProvider
     */
    public function test_run($file, array $expectedErrors, array $expectedWarnings)
    {
        $codeSniffer = new \PHP_CodeSniffer();
        $codeSniffer->reporting;
        $ruleset = $this->getRuleset();
        $codeSniffer->process(array(), $ruleset, array($this->getRuleName()));

        $sniffedFile = $codeSniffer->processFile($file);
        $this->validateErrors($sniffedFile, $expectedErrors);
        $this->validateWarnings($sniffedFile, $expectedWarnings);
    }

    public function fixturesProvider()
    {
        $fixtureDirectory = __DIR__ . '/fixtures/';
        return array(
            array($fixtureDirectory . 'ClassFileWithFileComment.php', array(3 => 1), array()),
            array($fixtureDirectory . 'ClassFileWithFileCommentAndExtraWhitespace.php', array(4 => 1), array()),
            array($fixtureDirectory . 'ClassFileWithClassComment.php', array(), array()),
            array($fixtureDirectory . 'ClassFileWithMethodComment.php', array(), array())
        );
    }

    protected function getRuleName()
    {
        return 'PhpCodingStandard.Commenting.NoFileCommentForClass';
    }

    private function validateErrors(\PHP_CodeSniffer_File $sniffedFile, array $expectedErrors)
    {
        $actualErrors = $sniffedFile->getErrors();

        foreach ($actualErrors as $line => $errorsPerColumn) {
            $this->assertTrue(
                isset($expectedErrors[$line]),
                'Unexpected error on line ' . $line
            );
            $this->assertSame(
                count($errorsPerColumn),
                $expectedErrors[$line],
                'Unexpected number of errors on line ' . $line
            );
        }

        foreach ($expectedErrors as $line => $errorCount) {
            $this->assertFalse(
                !isset($actualErrors[$line]),
                'Expected an error on line ' . $line
            );
        }
    }

    private function validateWarnings(\PHP_CodeSniffer_File $sniffedFile, array $expectedWarnings)
    {
    }

    protected function getRuleset()
    {
        return __DIR__ . '/../../../../../src/Matthias/PhpCodingStandard/ruleset.xml';
    }
}
