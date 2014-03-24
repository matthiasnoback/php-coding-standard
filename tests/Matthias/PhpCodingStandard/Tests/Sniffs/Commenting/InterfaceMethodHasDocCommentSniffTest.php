<?php

use Matthias\PhpCodingStandard\Tests\Sniffs\AbstractSniffTest;

class InterfaceMethodHasDocCommentSniffTest extends AbstractSniffTest
{
    public function fixturesProvider()
    {
        $fixtureDirectory = __DIR__ . '/fixtures/';
        return array(
            array($fixtureDirectory . 'InterfaceWithMethodWithDocComment.php', array(), array()),
            array($fixtureDirectory . 'InterfaceWithMethodWithNoDocComment.php', array(5 => 1), array()),
            array($fixtureDirectory . 'InterfaceWithTwoMethodsWithNoDocComments.php', array(5 => 1, 6 => 1), array()),
        );
    }

    protected function getRuleName()
    {
        return 'PhpCodingStandard.Commenting.InterfaceMethodHasDocComment';
    }

    protected function getRulesetXmlPath()
    {
        return __DIR__ . '/../../../../../../src/Matthias/PhpCodingStandard/ruleset.xml';
    }
}
