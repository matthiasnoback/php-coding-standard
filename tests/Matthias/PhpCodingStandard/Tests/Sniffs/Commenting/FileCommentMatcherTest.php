<?php

namespace Matthias\PhpCodingStandard\Tests\Sniffs\Commenting;

use Matthias\Codesniffer\TokenBuilder;
use Matthias\PhpCodingStandard\Sniffs\Commenting\FileCommentMatcher;

class FileCommentMatcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider tokensProvider
     */
    public function it_matches_a_file_comment(array $tokens, $tokenIndex, $expectedToMatch)
    {
        $matcher = new FileCommentMatcher();
        $this->assertSame($expectedToMatch, $matcher->matches($tokens, $tokenIndex));
    }

    public function tokensProvider()
    {
        return array(
            $this->docCommentAtBeginningOfFileWithTwoBlankLines(),
            $this->docCommentNotAtBeginningOfFile()
        );
    }

    private function docCommentAtBeginningOfFileWithTwoBlankLines()
    {
        return array(
            array(
                TokenBuilder::create('T_OPEN_TAG')->build(),
                TokenBuilder::create('T_WHITESPACE')->setContent("\n")->build(),
                TokenBuilder::create('T_DOC_COMMENT')->build(),
                TokenBuilder::create('T_DOC_COMMENT')->build(),
                TokenBuilder::create('T_DOC_COMMENT')->build(),
                TokenBuilder::create('T_WHITESPACE')->setContent("\n")->build(),
                TokenBuilder::create('T_WHITESPACE')->setContent("\n")->build()
            ),
            2,
            true
        );
    }

    private function docCommentNotAtBeginningOfFile()
    {
        return array(
            array(
                TokenBuilder::create('T_CLASS')->build(),
                TokenBuilder::create('T_DOC_COMMENT')->build()
            ),
            1,
            false
        );
    }
}
