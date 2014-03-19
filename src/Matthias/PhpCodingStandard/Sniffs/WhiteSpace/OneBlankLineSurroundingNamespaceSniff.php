<?php

use Matthias\PhpCodingStandard\Sniffs\WhiteSpace\NamespaceSurroundedByExactlyOneBlankLineMatcher;

class PhpCodingStandard_Sniffs_WhiteSpace_OneBlankLineSurroundingNamespaceSniff implements \PHP_CodeSniffer_Sniff
{
    public function register()
    {
        return array(
            T_NAMESPACE
        );
    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $matcher = new NamespaceSurroundedByExactlyOneBlankLineMatcher();

        if (!$matcher->matches($tokens, $stackPtr)) {
            $phpcsFile->addError(
                'Namespace declaration should be have one blank line before and after itself',
                $stackPtr
            );
        }
    }
}
