<?php

use Matthias\PhpCodingStandard\Tests\Sniffs\AbstractSniffTest;

class OneBlankLineSurroundingNamespaceSniffTest extends AbstractSniffTest
{
    public function fixturesProvider()
    {
        $fixtureDirectory = __DIR__ . '/fixtures/';

        return array(
            array($fixtureDirectory . 'TooManyBlankLinesBeforeNamespace.php', array(4 => 1), array()),
            array($fixtureDirectory . 'TooManyBlankLinesAfterNamespace.php', array(3 => 1), array()),
            array($fixtureDirectory . 'JustEnoughBlankLinesBeforeAndAfterNamespace.php', array(), array()),
        );
    }

    protected function getRuleName()
    {
        return 'PhpCodingStandard.WhiteSpace.OneBlankLineSurroundingNamespace';
    }

    protected function getRulesetXmlPath()
    {
        return __DIR__ . '/../../../../../../src/Matthias/PhpCodingStandard/ruleset.xml';
    }
}
