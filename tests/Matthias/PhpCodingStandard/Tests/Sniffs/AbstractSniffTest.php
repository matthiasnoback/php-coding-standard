<?php

namespace Matthias\PhpCodingStandard\Tests\Sniffs;

abstract class AbstractSniffTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider fixturesProvider
     */
    public function it_generates_the_expected_warnings_and_errors($file, array $expectedErrors, array $expectedWarnings)
    {
        $codeSniffer = new \PHP_CodeSniffer();
        $codeSniffer->process(array(), $this->getRulesetXmlPath(), array($this->getRuleName()));

        $sniffedFile = $codeSniffer->processFile($file);

        $this->fileHasExpectedErrors($sniffedFile, $expectedErrors);
        $this->fileHasExpectedWarnings($sniffedFile, $expectedWarnings);
    }

    /**
     * @return string The name of the rule you want to test (e.g. PSR2.Namespaces.NamespaceDeclaration)
     */
    abstract protected function getRuleName();

    /**
     * @return string The path to the ruleset.xml you want to test
     */
    abstract protected function getRulesetXmlPath();

    /**
     * Return an array of arrays of function arguments you want to use for testing different files and the expected
     * warnings/errors.
     *
     * @return array
     */
    abstract public function fixturesProvider();

    protected function fileHasExpectedErrors(\PHP_CodeSniffer_File $sniffedFile, array $expectedProblems)
    {
        $this->problemsMatchExpected($expectedProblems, $sniffedFile->getErrors(), 'error');
    }

    protected function fileHasExpectedWarnings(\PHP_CodeSniffer_File $sniffedFile, array $expectedWarnings)
    {
        $this->problemsMatchExpected($expectedWarnings, $sniffedFile->getWarnings(), 'warning');
    }

    private function problemsMatchExpected(array $expectedProblems, array $actualProblems, $type)
    {
        foreach ($actualProblems as $line => $problemsPerColumn) {
            $this->assertTrue(
                isset($expectedProblems[$line]),
                'Unexpected ' . $type . ' on line ' . $line
            );
            $this->assertSame(
                count($problemsPerColumn),
                $expectedProblems[$line],
                'Unexpected number of ' . $type . 's on line ' . $line
            );
        }

        foreach ($expectedProblems as $line => $problemCount) {
            $this->assertFalse(
                !isset($actualProblems[$line]),
                'Expected an ' . $type . ' on line ' . $line
            );
        }
    }
}
