<?php

use Matthias\PhpCodingStandard\Tests\Sniffs\AbstractSniffTest;

class NoFileCommentForClassSniffTest extends AbstractSniffTest
{
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

    protected function getRulesetXmlPath()
    {
        return __DIR__ . '/../../../../../../src/Matthias/PhpCodingStandard/ruleset.xml';
    }
}
