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
                ->token(T_WHITESPACE, ' ') // space
                ->token(T_STRING) // namespace root
                ->quantity() // sub namespaces
                    ->any()
                    ->succeeding()
                        ->token(T_NS_SEPARATOR)
                        ->token(T_STRING)
                    ->end()
                ->end()
                ->token(T_SEMICOLON) // end of namespace declaration
                ->quantity() // two blank lines
                    ->exactly(2)
                    ->token(T_WHITESPACE, "\n")
                ->end()
            ->end()
            ->build();

        $backwardSequence = SequenceBuilder::create()
            ->lookingBackward()
            ->expect()
                ->quantity()
                    // the first new line is part of the PHP open tag
                    ->exactly(1)
                    ->token(T_WHITESPACE, "\n")
                ->end()
            ->end()
            ->build();

        $oneBlankLineAfterNamespace = $forwardSequence->matches($tokens, $tokenIndex);
        $oneBlankLineBeforeNamespace = $backwardSequence->matches($tokens, $tokenIndex);

        return $oneBlankLineBeforeNamespace && $oneBlankLineAfterNamespace;
    }
}
