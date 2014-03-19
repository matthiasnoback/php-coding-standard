<?php

namespace Matthias\PhpCodingStandard\Sniffs\WhiteSpace;

use Matthias\Codesniffer\MatcherInterface;
use Matthias\Codesniffer\Sequence\SequenceBuilder;

class NamespaceSurroundedByExactlyOneBlankLineMatcher implements MatcherInterface
{
    public function matches(array $tokens, $tokenIndex)
    {
        $forwardSequence = SequenceBuilder::create()
            ->lookingForward()
            ->expect()
            ->exactly(1)
            ->token(T_WHITESPACE)
            ->then()
            ->exactly(1)
            ->token(T_STRING)
            ->then()
            ->exactly(1)
            ->token(T_SEMICOLON)
            ->then()
            ->exactly(2) // two new lines after each other means one blank line
            ->tokens(T_WHITESPACE, "\n")
            ->build();

        $backwardSequence = SequenceBuilder::create()
            ->lookingBackward()
            ->expect()
            ->exactly(1) // the first new line is part of the PHP open tag
            ->token(T_WHITESPACE, "\n")
            ->build();

        $oneBlankLineAfterNamespace = $forwardSequence->matches($tokens, $tokenIndex);
        $oneBlankLineBeforeNamespace = $backwardSequence->matches($tokens, $tokenIndex);

        return $oneBlankLineBeforeNamespace && $oneBlankLineAfterNamespace;
    }
}
