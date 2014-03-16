<?php

class PhpCodingStandard_Sniffs_NamingConventions_ValidVariableNameSniff extends
    \Squiz_Sniffs_NamingConventions_ValidVariableNameSniff
{
    protected function processMemberVar(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        // copied code from parent class
        $tokens = $phpcsFile->getTokens();

        $varName     = ltrim($tokens[$stackPtr]['content'], '$');
        $memberProps = $phpcsFile->getMemberProperties($stackPtr);
        if (empty($memberProps) === true) {
            // Couldn't get any info about this variable, which
            // generally means it is invalid or possibly has a parse
            // error. Any errors will be reported by the core, so
            // we can ignore it.
            return;
        }

        // end of copied code

        // always validate as if the member variable is public
        $public    = true;
        $errorData = array($varName);

        if (PHP_CodeSniffer::isCamelCaps($varName, false, $public, false) === false) {
            $error = 'Variable "%s" is not in valid camel caps format';
            $phpcsFile->addError($error, $stackPtr, 'MemberNotCamelCaps', $errorData);
        }
    }
}
