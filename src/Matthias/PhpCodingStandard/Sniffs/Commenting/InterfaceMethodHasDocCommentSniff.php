<?php

use Matthias\Codesniffer\Sequence\SequenceBuilder;

class PhpCodingStandard_Sniffs_Commenting_InterfaceMethodHasDocCommentSniff implements \PHP_CodeSniffer_Sniff
{
    public function register()
    {
        return array(
            T_FUNCTION
        );
    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $currentToken = $tokens[$stackPtr];

        $interfaceConditions = array_filter($currentToken['conditions'], function($tokenCode) {
            return $tokenCode === T_INTERFACE;
        });

        if (count($interfaceConditions) === 0) {
            // this function is not part of an interface
            return;
        }

        $sequence = SequenceBuilder::create()
            ->lookingBackward()
            ->expect()
                ->quantity()
                    ->any()
                    ->choice()
                        ->token(T_WHITESPACE)
                        ->token(T_PUBLIC)
                        ->token(T_STATIC)
                    ->end()
                ->end()
                ->quantity()
                    ->atLeast(3)
                    ->token(T_DOC_COMMENT)
                ->end()
            ->end()
            ->build();
        /** @var $sequence \Matthias\Codesniffer\Sequence\ForwardSequence */

        if (!$sequence->matches($tokens, $stackPtr)) {
            $phpcsFile->addError('Interface method should have a doc comment', $stackPtr);
        }
    }
}
