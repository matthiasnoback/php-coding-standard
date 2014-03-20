<?php

namespace Matthias\PhpCodingStandard\Sniffs\WhiteSpace;

use Matthias\Codesniffer\MatcherInterface;
use Matthias\Codesniffer\Sequence\Expectation\ExactMatch;
use Matthias\Codesniffer\Sequence\Expectation\Quantity;
use Matthias\Codesniffer\Sequence\ForwardSequence;
use Matthias\Codesniffer\Sequence\SequenceBuilder;

class NamespaceSurroundedByExactlyOneBlankLineMatcher implements MatcherInterface
{
    public function matches(array $tokens, $tokenIndex)
    {
        $forwardSequence = new ForwardSequence();
        $whitespace = new Quantity(new ExactMatch(T_WHITESPACE), 1, 1);
        $forwardSequence->addExpectation($whitespace);
        $namespaceRoot = new Quantity(new ExactMatch(T_STRING), 1, 1);
        $forwardSequence->addExpectation($namespaceRoot);
        $subNamespaces = new Quantity(array(
            new ExactMatch(T_NS_SEPARATOR),
            new ExactMatch(T_STRING)
        ), null, null);
        $forwardSequence->addExpectation($subNamespaces);
        $semicolon = new Quantity(new ExactMatch(T_SEMICOLON), 1, 1);
        $forwardSequence->addExpectation($semicolon);
        $blankLine = new Quantity(new ExactMatch(T_WHITESPACE, "\n"), 2, 2);
        $forwardSequence->addExpectation($blankLine);

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
