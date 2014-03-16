<?php

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

        for ($currentToken = $stackPtr - 1; $currentToken >= 0; $currentToken--) {
            if (!in_array($tokens[$currentToken]['type'], array('T_WHITESPACE', 'T_OPEN_TAG'))) {
                // this comment is not placed at the beginning of the file
                return;
            }
        }

        $numberOfNewLines = 0;
        for ($nextToken = $stackPtr + 1; $nextToken < count($tokens); $nextToken++) {
            $nextType = $tokens[$nextToken]['type'];
            $nextContent = $tokens[$nextToken]['content'];

            if ($nextType === 'T_DOC_COMMENT') {
                // more doccomment lines
                continue;
            }

            if ($nextType === 'T_WHITESPACE' && $nextContent == "\n") {
                // blank lines
                $numberOfNewLines++;
                continue;
            }

            // some other type
            break;
        }

        $docCommentIsFileComment = $numberOfNewLines >= 2;

        if ($docCommentIsFileComment) {
            // stand-alone file comment
            $phpcsFile->addError('Class file should not have a file comment', $stackPtr);
        }
    }
}
