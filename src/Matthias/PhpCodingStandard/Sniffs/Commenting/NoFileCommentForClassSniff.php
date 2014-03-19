<?php

use Matthias\PhpCodingStandard\Sniffs\Commenting\FileCommentMatcher;

class PhpCodingStandard_Sniffs_Commenting_NoFileCommentForClassSniff implements \PHP_CodeSniffer_Sniff
{
    public function register()
    {
        return array(
            T_DOC_COMMENT
        );
    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $matcher = new FileCommentMatcher();

        if ($matcher->matches($tokens, $stackPtr)) {
            // stand-alone file comment
            $phpcsFile->addError('Class file should not have a file comment', $stackPtr);
        }
    }
}
